<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 13.07.18
 * Time: 12:33
 */

namespace app\controllers;


use app\models\service\SynchronizeHistory;
use app\models\user\UserRecord;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;

class ConsoleController extends Controller
{
    public function actionSynchronizeDataBase() {

        $time_last_sync = SynchronizeHistory::getLastSynchronize();

        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;

        $db_old = Instance::ensure('db_old_mysql', Connection::class);
        $db_old->getSchema()->refresh();
        $db_old->enableSlaves = false;

        $db = Instance::ensure('db', Connection::class);
        $db->getSchema()->refresh();
        $db->enableSlaves = false;


        $sql = "
        SELECT * 
        FROM company_names";
        $companies = $db_old->createCommand($sql)
            ->queryAll();

        $sql_insert = "
        INSERT INTO public.events
        (id_disinfector, id_customer, id_external, id_point_status, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:id_disinfector, :id_customer, :id_external, :id_point_status, :created_at, 
        :created_by, :updated_at, :updated_by)";

        $count_sync_row = 0;
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
                $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(new \DateTime($event['created']));
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
                //$event['pointNum']++;
                $db->createCommand($sql_insert)
                    ->bindValue(':id_disinfector', $event['executor'])
                    ->bindValue(':id_customer', $event['company'])
                    ->bindValue(':id_external', $event['pointNum'])
                    ->bindValue(':id_point_status', $event['pointProp'])
                    ->bindValue(':created_at', $created_at)
                    ->bindValue(':created_by', $created_by)
                    ->bindValue(':updated_at', $updated_at)
                   ->bindValue(':updated_by', $updated_by)
                    ->query();

                $count_sync_row++;
            }
        }

        SynchronizeHistory::addSynchronize($count_sync_row);
    }
}
