<?php
namespace app\repositories;

use app\dto\Synchronize;
use app\dto\SynchronizeLast;
use app\entities\SynchronizeRecord;
use app\exceptions\SynchronizeNotFound;
use DateTime;
use RuntimeException;

/**
 * Class SynchronizeRepository
 * @package app\repositories
 */
class SynchronizeRepository implements SynchronizeRepositoryInterface
{
    /**
     * @param $id
     * @return Synchronize
     * @throws SynchronizeNotFound
     */
    public function get($id)
    {
        /**
         * @var SynchronizeRecord $synchronizeRecord
         */
        $synchronizeRecord = $this->findOrFail($id);

        $synchronize = $this->fillSynchronize($synchronizeRecord);

        return $synchronize;
    }

    /**
     * @param Synchronize $synchronize
     * @return Synchronize
     * @throws \Throwable
     */
    public function add(Synchronize $synchronize)
    {
        $synchronizeRecord = new SynchronizeRecord();

        $synchronizeRecord = $this->fillSynchronizeRecord($synchronizeRecord, $synchronize);

        if (!$synchronizeRecord->insert()) {
            throw new RuntimeException();
        }

        $synchronize->setId($synchronizeRecord->id);

        return $synchronize;
    }

    /**
     * @param Synchronize $synchronize
     * @return Synchronize
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Synchronize $synchronize)
    {
        /**
         * @var SynchronizeRecord $synchronizeRecord
         */
        $synchronizeRecord = $this->findOrFail($synchronize->getId());

        $synchronizeRecord = $this->fillSynchronizeRecord($synchronizeRecord, $synchronize);

        $synchronizeRecord->update();

        return $synchronize;
    }

    /**
     * @param Synchronize $synchronize
     * @return Synchronize
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Synchronize $synchronize)
    {
        $synchronizeRecord = $this->findOrFail($synchronize->getId());

        $synchronizeRecord->is_active = false;

        if (!$synchronizeRecord->update()) {
            throw new \RuntimeException();
        }

        $synchronize->setIsActive(false);

        return $synchronize;
    }

    /**
     * @return Synchronize[]
     */
    public function all()
    {
        $synchronizeRecords = SynchronizeRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $synchronizeHistory = [];
        /**
         * @var SynchronizeRecord $synchronizeRecord
         */
        foreach ($synchronizeRecords as $synchronizeRecord) {
            $synchronizeHistory [] = $this->fillSynchronize($synchronizeRecord);
        }

        return $synchronizeHistory;
    }

    /**
     * @param $id
     * @return SynchronizeRecord
     * @throws SynchronizeNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var SynchronizeRecord $synchronize
         */
        if (!($synchronize = SynchronizeRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new SynchronizeNotFound();
        }

        return $synchronize;
    }

    /**
     * @param SynchronizeRecord $synchronizeRecord
     * @return Synchronize
     */
    private function fillSynchronize($synchronizeRecord)
    {
        $synchronize = (new Synchronize())
            ->setId($synchronizeRecord->id)
            ->setCountSyncRow($synchronizeRecord->count_sync_row);

        return $synchronize;
    }

    /**
     * @param SynchronizeRecord $synchronizeRecord
     * @param Synchronize $synchronize
     * @return SynchronizeRecord
     */
    private function fillSynchronizeRecord($synchronizeRecord, $synchronize)
    {
        $synchronizeRecord->count_sync_row = $synchronize->getCountSyncRow();

        return $synchronizeRecord;
    }

    /**
     * @return SynchronizeLast
     */
    public function getLastSynchronize()
    {
        $lastSyncRecord = SynchronizeRecord::find()->select('created_at')
            ->orderBy('created_at DESC')
            ->limit(1)
            ->all();

        if ($lastSyncRecord === null) {
            $syncLast = new SynchronizeLast();
        } else {
            $syncLast = (new SynchronizeLast())
                ->setDateTimeLastSync(DateTime::createFromFormat('U', (string)$lastSyncRecord->created_at));
        }

        return $syncLast;
    }
}
