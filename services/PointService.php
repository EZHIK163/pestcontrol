<?php
namespace app\services;

use app\dto\FileCustomer;
use app\dto\Point;
use app\exceptions\FileCustomerNotFound;
use app\repositories\FileCustomerRepositoryInterface;
use app\repositories\PointRepositoryInterface;
use app\repositories\PointStatusRepositoryInterface;
use yii\helpers\ArrayHelper;

/**
 * Class PointService
 * @package app\services
 */
class PointService
{
    private $pointRepository;
    private $fileCustomerRepository;
    private $pointStatusRepository;

    /**
     * PointService constructor.
     * @param PointRepositoryInterface $pointRepository
     * @param FileCustomerRepositoryInterface $fileCustomerRepository
     * @param PointStatusRepositoryInterface $pointStatusRepository
     */
    public function __construct(
        PointRepositoryInterface $pointRepository,
        FileCustomerRepositoryInterface $fileCustomerRepository,
        PointStatusRepositoryInterface $pointStatusRepository
    ) {
        $this->fileCustomerRepository = $fileCustomerRepository;
        $this->pointRepository = $pointRepository;
        $this->pointStatusRepository = $pointStatusRepository;
    }

    /**
     * @param $idFileCustomer
     * @param $points
     * @throws \app\exceptions\PointNotFound
     */
    public function savePoints($idFileCustomer, $points)
    {
        $fileCustomer = $this->fileCustomerRepository->get($idFileCustomer);

        $idCustomer = $fileCustomer->getCustomer()->getId();

        foreach ($points as $point) {
            if ($point['is_new'] === true) {
                $newPoint = (new Point())
                    ->setIdInternal($point['id_internal'])
                    ->setXCoordinate($point['x'])
                    ->setYCoordinate($point['y'])
                    ->setFileCustomer($fileCustomer)
                    ->setIsEnable(true);

                $this->pointRepository->add($newPoint);
            } else {
                $pointUpdate = $this->pointRepository->getByIdInternal($point['id_internal'], $idCustomer);

                $pointUpdate->setXCoordinate($point['x'])
                    ->setYCoordinate($point['y'])
                    ->setFileCustomer($fileCustomer);

                $this->pointRepository->save($pointUpdate);
            }
        }
    }

    /**
     * @param $id_customer
     * @return array
     */
    public function getPointsForManager($id_customer)
    {
        /**
         * @var Point[] $points
         */
        $points = $this->pointRepository->all();

        $preparedPoints = [];
        foreach ($points as $point) {
            $fileCustomer = $point->getFileCustomer();
            if (!is_null($id_customer) && $fileCustomer && $fileCustomer->getCustomer()->getId() == $id_customer
                or $id_customer === null) {
                $preparedPoints [] = $point;
            }
        }

        $finishPoints = [];
        /**
         * @var Point $preparedPoint
         */
        foreach ($preparedPoints as $preparedPoint) {
            $fileCustomer = $preparedPoint->getFileCustomer();
            $title = $fileCustomer->getTitle();
            if ($fileCustomer->isEnable() === false) {
                $status = 'Отключена схема';
            } else {
                if ($preparedPoint->isEnable() == false) {
                    $status = 'Отключена';
                } elseif ($preparedPoint->getXCoordinate() <= 0 or $preparedPoint->getYCoordinate() <= 0) {
                    $status = 'Не прикреплена';
                    $title = '';
                } else {
                    $status = 'Прикреплена';
                }
            }
            $finishPoints [] = [
                'id'            => $preparedPoint->getId(),
                'title'         => $title,
                'id_internal'   => $preparedPoint->getIdInternal(),
                'x_coordinate'  => $preparedPoint->getXCoordinate(),
                'y_coordinate'  => $preparedPoint->getYCoordinate(),
                'status'        => $status
            ];
        }

        return $finishPoints;
    }

    /**
     * @param $id
     * @return Point
     */
    public function getItemForEditing($id)
    {
        $point = $this->pointRepository->get($id);

        return $point;
    }

    /**
     * @param int $id
     * @return int
     */
    public function getIdCustomerPoint($id)
    {
        $point = $this->pointRepository->get($id);

        return $point->getFileCustomer()->getCustomer()->getId();
    }

    /**
     * @param $id
     * @param $xCoordinate
     * @param $yCoordinate
     * @param $title
     * @param $idFileCustomer
     * @return bool
     */
    public function saveItem($id, $xCoordinate, $yCoordinate, $title, $idFileCustomer)
    {
        $point = $this->pointRepository->get($id);

        if ($point->getFileCustomer()->getId() != $idFileCustomer) {
            $xCoordinate = 0;
            $yCoordinate = 0;
        }

        $fileCustomer = $this->fileCustomerRepository->get($idFileCustomer);

        $point->setXCoordinate($xCoordinate)
            ->setYCoordinate($yCoordinate)
            ->setTitle($title)
            ->setFileCustomer($fileCustomer)
            ->setIsActive(true);

        $this->pointRepository->save($point);

        return true;
    }

    /**
     * @param $id
     */
    public function disablePoint($id)
    {
        $point = $this->pointRepository->get($id);
        $this->pointRepository->disable($point);
    }

    /**
     * @param $id
     */
    public function enablePoint($id)
    {
        $point = $this->pointRepository->get($id);
        $point->setIsEnable(true);
        $this->pointRepository->save($point);
    }

    /**
     * @return array
     */
    public function getPointStatusesForDropDownList()
    {
        $statuses = $this->pointStatusRepository->all();

        foreach ($statuses as &$status) {
            $status = $status->toArray();
        }

        return ArrayHelper::map($statuses, 'id', 'description');
    }

    /**
     * @return \app\dto\PointStatus[]
     */
    public function getStatusesForApplication()
    {
        $statuses = $this->pointStatusRepository->all();

        foreach ($statuses as &$status) {
            $status = $status->toArray();
        }

        return $statuses;
    }
}
