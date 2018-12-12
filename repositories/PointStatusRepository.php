<?php
namespace app\repositories;

use app\dto\PointStatus;
use app\entities\PointStatusRecord;
use app\exceptions\PointStatusNotFound;
use RuntimeException;

/**
 * Class PointStatusRepository
 * @package app\repositories
 */
class PointStatusRepository implements PointStatusRepositoryInterface
{
    /**
     * @param $id
     * @return PointStatus
     * @throws PointStatusNotFound
     */
    public function get($id)
    {
        /**
         * @var PointStatusRecord $pointStatusRecord
         */
        $pointStatusRecord = $this->findOrFail($id);

        $pointStatus = $this->fillPointStatus($pointStatusRecord);

        return $pointStatus;
    }

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     * @throws \Throwable
     */
    public function add(PointStatus $pointStatus)
    {
        $pointStatusRecord = new PointStatusRecord();

        $pointStatusRecord = $this->fillPointStatusRecord($pointStatusRecord, $pointStatus);

        if (!$pointStatusRecord->insert()) {
            throw new RuntimeException();
        }

        $pointStatus->setId($pointStatusRecord->id);

        return $pointStatus;
    }

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(PointStatus $pointStatus)
    {
        /**
         * @var PointStatusRecord $pointStatusRecord
         */
        $pointStatusRecord = $this->findOrFail($pointStatus->getId());

        $pointStatusRecord = $this->fillPointStatusRecord($pointStatusRecord, $pointStatus);

        $pointStatusRecord->update();

        return $pointStatus;
    }

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(PointStatus $pointStatus)
    {
        $pointStatusRecord = $this->findOrFail($pointStatus->getId());

        $pointStatusRecord->is_active = false;

        if (!$pointStatusRecord->update()) {
            throw new \RuntimeException();
        }

        $pointStatus->setIsActive(false);

        return $pointStatus;
    }

    /**
     * @return PointStatus[]
     */
    public function all()
    {
        $pointStatusRecords = PointStatusRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $pointStatuses = [];
        /**
         * @var PointStatusRecord $pointStatusRecord
         */
        foreach ($pointStatusRecords as $pointStatusRecord) {
            $pointStatuses [] = $this->fillPointStatus($pointStatusRecord);
        }

        return $pointStatuses;
    }

    /**
     * @param $id
     * @return PointStatusRecord
     * @throws PointStatusNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var PointStatusRecord $pointStatus
         */
        if (!($pointStatus = PointStatusRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new PointStatusNotFound();
        }

        return $pointStatus;
    }

    /**
     * @param PointStatusRecord $pointStatusRecord
     * @return PointStatus
     */
    private function fillPointStatus($pointStatusRecord)
    {
        $pointStatus = (new PointStatus())
            ->setId($pointStatusRecord->id)
            ->setDescription($pointStatusRecord->description)
            ->setCode($pointStatusRecord->code);

        return $pointStatus;
    }

    /**
     * @param PointStatusRecord $pointStatusRecord
     * @param PointStatus $pointStatus
     * @return PointStatusRecord
     */
    private function fillPointStatusRecord($pointStatusRecord, $pointStatus)
    {
        $pointStatusRecord->code = $pointStatus->getCode();
        $pointStatusRecord->description = $pointStatus->getDescription();

        return $pointStatusRecord;
    }

    /**
     * @param $code
     * @return PointStatus
     * @throws PointStatusNotFound
     */
    public function getByCode($code)
    {
        /**
         * @var PointStatusRecord $pointStatusRecord
         */
        if (!($pointStatusRecord = PointStatusRecord::find()
            ->andWhere(['code'            => $code])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new PointStatusNotFound();
        }

        $pointStatus = $this->fillPointStatus($pointStatusRecord);

        return $pointStatus;
    }
}
