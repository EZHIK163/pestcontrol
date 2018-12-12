<?php
namespace app\repositories;

use app\dto\FileCustomer;
use app\dto\Point;
use app\entities\PointRecord;
use app\exceptions\PointNotFound;
use RuntimeException;
use Yii;

/**
 * Class PointRepository
 * @package app\repositories
 */
class PointRepository implements PointRepositoryInterface
{
    private $fileCustomerRepository;

    /**
     * PointRepository constructor.
     * @param FileCustomerRepositoryInterface $fileCustomerRepository
     */
    public function __construct(FileCustomerRepositoryInterface $fileCustomerRepository)
    {
        $this->fileCustomerRepository = $fileCustomerRepository;
    }

    /**
     * @param $id
     * @return Point
     * @throws PointNotFound
     */
    public function get($id)
    {
        /**
         * @var PointRecord $pointRecord
         */
        $pointRecord = $this->findOrFail($id);

        $point = $this->fillPoint($pointRecord);

        return $point;
    }

    /**
     * @param Point $point
     * @return Point
     * @throws \Throwable
     */
    public function add(Point $point)
    {
        $pointRecord = new PointRecord();

        $pointRecord = $this->fillPointRecord($pointRecord, $point);

        if (!$pointRecord->insert()) {
            throw new RuntimeException();
        }

        $point->setId($pointRecord->id);

        return $point;
    }

    /**
     * @param Point $point
     * @return Point
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Point $point)
    {
        /**
         * @var PointRecord $pointRecord
         */
        $pointRecord = $this->findOrFail($point->getId());

        $pointRecord = $this->fillPointRecord($pointRecord, $point);

        $pointRecord->update();

        return $point;
    }

    /**
     * @param Point $point
     * @return Point
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Point $point)
    {
        $pointRecord = $this->findOrFail($point->getId());

        $pointRecord->is_active = false;

        if (!$pointRecord->update()) {
            throw new \RuntimeException();
        }

        $point->setIsActive(false);

        return $point;
    }

    /**
     * @param bool $isActive
     * @return Point[]
     */
    public function all($isActive = true)
    {
        $pointRecords = PointRecord::find();

        $isActive !== null && $pointRecords->where(['is_active'  => $isActive]);

        $pointRecords = $pointRecords->orderBy('id ASC')
            ->all();

        $points = [];
        /**
         * @var PointRecord $pointRecord
         */
        foreach ($pointRecords as $pointRecord) {
            $points [] = $this->fillPoint($pointRecord);
        }

        return $points;
    }

    /**
     * @param $id
     * @return PointRecord
     * @throws PointNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var PointRecord $point
         */
        if (!($point = PointRecord::find()
            ->andWhere(['id'            => $id])
            ->one())) {
            throw new PointNotFound();
        }

        return $point;
    }

    /**
     * @param PointRecord $pointRecord
     * @return Point
     */
    private function fillPoint($pointRecord)
    {
        $file = $this->fileCustomerRepository->get($pointRecord->id_file_customer);
        $point = (new Point())
            ->setIsActive($pointRecord->is_active)
            ->setId($pointRecord->id)
            ->setTitle($pointRecord->title)
            ->setFileCustomer($file)
            ->setIdInternal($pointRecord->id_internal)
            ->setXCoordinate($pointRecord->x_coordinate)
            ->setYCoordinate($pointRecord->y_coordinate);

        return $point;
    }

    /**
     * @param PointRecord $pointRecord
     * @param Point $point
     * @return PointRecord
     */
    private function fillPointRecord($pointRecord, $point)
    {
        $pointRecord->title = $point->getTitle();
        $pointRecord->id_internal = $point->getIdInternal();
        $pointRecord->id_file_customer = $point->getFileCustomer()->getId();
        $pointRecord->x_coordinate = $point->getXCoordinate();
        $pointRecord->y_coordinate = $point->getYCoordinate();
        $pointRecord->is_active = $point->isActive();

        return $pointRecord;
    }

    /**
     * @param $idInternal
     * @param $idCustomer
     * @return Point
     */
    public function getByIdInternal($idInternal, $idCustomer)
    {
        /**
         * @var PointRecord $pointRecord
         */
        $pointRecord = PointRecord::find()
            ->select('points.*')
            ->join('inner join', 'file_customer', 'file_customer.id = points.id_file_customer')
            ->where(['points.id_internal'  => $idInternal])
            ->andWhere(['file_customer.id_customer' => $idCustomer])
            ->one();

        $point = $this->fillPoint($pointRecord);

        return $point;
    }

    /**
     * @param $idCustomer
     * @return int
     * @throws \yii\db\Exception
     */
    public function getMaxIdInternal($idCustomer)
    {
        $sql = "
        SELECT max(p.id_internal) 
        FROM public.points as p
        JOIN public.file_customer as fc ON fc.id = p.id_file_customer
        WHERE fc.id_customer = :id_customer";

        $point = Yii::$app->db->createCommand($sql)
            ->bindValue(':id_customer', $idCustomer)
            ->queryOne();

        return $point['max'];
    }

    /**
     * @param $idFileCustomer
     * @return Point[]
     */
    public function getItemsByIdFileCustomer($idFileCustomer)
    {
        /**
         * @var PointRecord[] $pointRecords
         */
        $pointRecords = PointRecord::find()
            ->select('points.*')
            ->join('inner join', 'file_customer', 'file_customer.id = points.id_file_customer')
            ->andWhere(['file_customer.id' => $idFileCustomer])
            ->all();

        $points = [];
        /**
         * @var PointRecord $pointRecord
         */
        foreach ($pointRecords as $pointRecord) {
            $points [] = $this->fillPoint($pointRecord);
        }

        return $points;
    }
}
