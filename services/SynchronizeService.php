<?php
namespace app\services;

use app\dto\EventSynchronize;
use app\dto\Synchronize;
use app\entities\UserRecord;
use app\repositories\EventRepositoryInterface;
use app\repositories\SynchronizeRepositoryInterface;
use DateTime;
use Yii;
use yii\db\Connection;
use yii\di\Instance;

/**
 * Class SynchronizeService
 * @package app\services
 */
class SynchronizeService
{
    private $synchronizeRepository;
    private $eventRepository;

    /**
     * SynchronizeService constructor.
     * @param SynchronizeRepositoryInterface $synchronizeRepository
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(
        SynchronizeRepositoryInterface $synchronizeRepository,
        EventRepositoryInterface $eventRepository
    ) {
        $this->synchronizeRepository = $synchronizeRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @return string
     */
    public function getLastSynchronize()
    {
        $lastSync = $this->synchronizeRepository->getLastSynchronize();

        return $lastSync->getDateTimeLastSync()->format('Y-m-d H:i:s');
    }

    /**
     * @param $countSyncRow
     */
    public function addSynchronize($countSyncRow)
    {
        $synchronize = (new Synchronize())->setCountSyncRow($countSyncRow);

        $this->synchronizeRepository->add($synchronize);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function sync()
    {
        $time_last_sync = $this->getLastSynchronize();

        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;

        $db_old = Instance::ensure('db_old_mysql', Connection::class);
        $db_old->getSchema()->refresh();
        $db_old->enableSlaves = false;

        $sql = "
        SELECT * 
        FROM company_names";
        $companies = $db_old->createCommand($sql)
            ->queryAll();

        $count_sync_row = 0;
        $syncEvents = [];
        foreach ($companies as $company) {
            $name_table = $company['tbl_names'];

            $sql = "
            SELECT * FROM {$name_table}
            WHERE created > :last_time_sync";

            $events = $db_old->createCommand($sql)
                ->bindValue(':last_time_sync', $time_last_sync)
                ->queryAll();

            foreach ($events as $event) {
                if (!isset($event['created'])) {
                    $event['created'] = $event['Created'];
                }
                $updated_at = $created_at = Yii::$app->formatter->asTimestamp(new DateTime($event['created']));
                if ($event['executor'] == 666
                    or $event['executor'] == 110
                    or $event['executor'] == 0) {
                    continue;
                }
                if ($event['executor'] == 777) {
                    $event['executor'] = 14;
                }

                $event['pointProp']++;
                $event['company']++;

                $syncEvents [] = (new EventSynchronize())
                    ->setIdDisinfector($event['executor'])
                    ->setIdCustomer($event['company'])
                    ->setIdExternal($event['pointNum'])
                    ->setIdPointStatus($event['pointProp'])
                    ->setCreatedAt($created_at)
                    ->setCreatedBy($created_by)
                    ->setUpdatedAt($updated_at)
                    ->setUpdatedBy($updated_by);

                $count_sync_row++;
            }
        }

        $this->eventRepository->addEventFromOldDb($syncEvents);

        $this->addSynchronize($count_sync_row);
    }
}
