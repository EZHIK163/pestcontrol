<?php
namespace app\repositories;

use app\dto\Disinfector;
use app\entities\DisinfectorRecord;
use app\exceptions\DisinfectorNotFound;
use RuntimeException;

/**
 * Class DisinfectorRepository
 * @package app\repositories
 */
class DisinfectorRepository implements DisinfectorRepositoryInterface
{
    /**
     * @param $id
     * @throws DisinfectorNotFound
     * @return Disinfector
     */
    public function get($id)
    {
        /**
         * @var DisinfectorRecord $disinfectorRecord
         */
        $disinfectorRecord = $this->findOrFail($id);

        $disinfector = $this->fillDisinfector($disinfectorRecord);

        return $disinfector;
    }

    /**
     * @param Disinfector $disinfector
     * @throws \Throwable
     * @return Disinfector
     */
    public function add(Disinfector $disinfector)
    {
        $disinfectorRecord = new DisinfectorRecord();

        $disinfectorRecord = $this->fillDisinfectorRecord($disinfectorRecord, $disinfector);

        if (!$disinfectorRecord->insert()) {
            throw new RuntimeException();
        }

        $disinfector->setId($disinfectorRecord->id);

        return $disinfector;
    }

    /**
     * @param Disinfector $disinfector
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Disinfector
     */
    public function save(Disinfector $disinfector)
    {
        /**
         * @var DisinfectorRecord $disinfectorRecord
         */
        $disinfectorRecord = $this->findOrFail($disinfector->getId());

        $disinfectorRecord = $this->fillDisinfectorRecord($disinfectorRecord, $disinfector);

        $disinfectorRecord->update();

        return $disinfector;
    }

    /**
     * @param Disinfector $disinfector
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Disinfector
     */
    public function remove(Disinfector $disinfector)
    {
        $disinfectorRecord = $this->findOrFail($disinfector->getId());

        $disinfectorRecord->is_active = false;

        if (!$disinfectorRecord->update()) {
            throw new \RuntimeException();
        }

        $disinfector->setIsActive(false);

        return $disinfector;
    }

    /**
     * @return Disinfector[]
     */
    public function all()
    {
        $disinfectorRecords = DisinfectorRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $disinfectors = [];
        /**
         * @var DisinfectorRecord $disinfectorRecord
         */
        foreach ($disinfectorRecords as $disinfectorRecord) {
            $disinfectors [] = $this->fillDisinfector($disinfectorRecord);
        }

        return $disinfectors;
    }

    /**
     * @param $id
     * @throws DisinfectorNotFound
     * @return DisinfectorRecord
     */
    private function findOrFail($id)
    {
        /**
         * @var DisinfectorRecord $disinfector
         */
        if (!($disinfector = DisinfectorRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new DisinfectorNotFound();
        }

        return $disinfector;
    }

    /**
     * @param DisinfectorRecord $disinfectorRecord
     * @return Disinfector
     */
    private function fillDisinfector($disinfectorRecord)
    {
        $disinfector = (new Disinfector())
            ->setId($disinfectorRecord->id)
            ->setPhone($disinfectorRecord->phone)
            ->setFullName($disinfectorRecord->full_name);

        return $disinfector;
    }

    /**
     * @param DisinfectorRecord $disinfectorRecord
     * @param Disinfector $disinfector
     * @return DisinfectorRecord
     */
    private function fillDisinfectorRecord($disinfectorRecord, $disinfector)
    {
        $disinfectorRecord->phone = $disinfector->getPhone();
        $disinfectorRecord->full_name = $disinfector->getFullName();

        return $disinfectorRecord;
    }
}
