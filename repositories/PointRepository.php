<?php
namespace app\repositories;

use app\dto\Point;
use app\entities\PointRecord;
use app\exceptions\FileCustomerNotFound;
use app\exceptions\PointNotFound;
use RuntimeException;
use Yii;

/**
 * Class PointRepository
 * @package app\repositories
 */
class PointRepository implements PointRepositoryInterface
{
    /**
     * @var FileCustomerRepositoryInterface
     */
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
     * @throws PointNotFound
     * @return Point
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
     * @throws \Throwable
     * @return Point
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Point
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Point
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
     * @return Point[]
     */
    public function all()
    {
        $pointRecords = PointRecord::find()
            ->where(['is_active'  => true])
            ->orderBy('id ASC')
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
     * @throws PointNotFound
     * @return PointRecord
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
            ->setId($pointRecord->id)
            ->setTitle($pointRecord->title)
            ->setFileCustomer($file)
            ->setIdInternal($pointRecord->id_internal)
            ->setXCoordinate($pointRecord->x_coordinate)
            ->setYCoordinate($pointRecord->y_coordinate)
            ->setIsEnable($pointRecord->is_enable);

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
        $pointRecord->is_enable = $point->isEnable();

        return $pointRecord;
    }

    /**
     * @param $idInternal
     * @param $idCustomer
     * @throws PointNotFound
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

        if (!$pointRecord) {
            throw new PointNotFound();
        }

        $point = $this->fillPoint($pointRecord);

        return $point;
    }

    /**
     * @param $idCustomer
     * @throws \yii\db\Exception
     * @return int
     */
    public function getMaxIdInternal($idCustomer)
    {
        $sql = "
        SELECT max(p.id_internal) 
        FROM public.points as p
        JOIN public.file_customer as fc ON fc.id = p.id_file_customer
        WHERE fc.id_customer = :id_customer AND p.is_active = true";

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
            ->andWhere(['points.is_enable' => true])
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
     * @param Point $point
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Point
     */
    public function disable(Point $point)
    {
        $pointRecord = $this->findOrFail($point->getId());

        $pointRecord->is_enable = false;

        if (!$pointRecord->update()) {
            throw new \RuntimeException();
        }

        $point->setIsEnable(false);

        return $point;
    }
}
