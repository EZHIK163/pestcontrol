<?php
namespace app\commands;

use app\entities\UserRecord;
use DateTime;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\Console;

/**
 * Команда переноса данных из старой базы в новую
 */
class MoveDataFromOldDbCommand extends Controller
{
    /**
     * Выполнить команду
     */
    public function actionIndex()
    {
        $db_old = Instance::ensure('db_old', Connection::class);
        $db_old->getSchema()->refresh();
        $db_old->enableSlaves = false;

        $sql = "
        SELECT * 
        FROM company_names";
        $companies = $db_old->createCommand($sql)
            ->queryAll();
        $sql = "
        INSERT INTO public.customers 
        (name, created_at, created_by, updated_at, updated_by, code)
        VALUES 
        (:name, :created_at, :created_by, :updated_at, :updated_by, :code)";
        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;
        foreach ($companies as $company) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            \Yii::$app->db->createCommand($sql)
                ->bindValue(':name', $company['name'])
                ->bindValue(':code', $company['tbl_names'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $sql = "
        SELECT * 
        FROM desinf";
        $disinfectors = $db_old->createCommand($sql)
            ->queryAll();

        $sql = "
        INSERT INTO public.disinfectors 
        (full_name, phone, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:full_name, :phone, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($disinfectors as $disinfector) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            \Yii::$app->db->createCommand($sql)
                ->bindValue(':full_name', $disinfector['des_fio'])
                ->bindValue(':phone', $disinfector['des_tel'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $sql = "
        SELECT * 
        FROM point_status";
        $point_status = $db_old->createCommand($sql)
            ->queryAll();
        $sql = "
        INSERT INTO public.point_status 
        (description, code, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:description, :code, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($point_status as $point) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            switch ($point['stt_id']) {
                case 0:
                    $code = 'not_touch';
                    $description = 'Приманка целая/клеевая подложка чистая';

                    break;
                case 1:
                    $code = 'part_replace';
                    $description = 'Замена приманки/Клеевой подложки-следов вредителей нет';

                    break;
                case 2:
                    $code = 'full_replace';
                    $description = 'Замена приманки/Клеевой подложки-следы вредителей';

                    break;
                case 3:
                    $code = 'caught';
                    $description = 'Пойман вредитель (старое)';

                    break;
            }
            \Yii::$app->db->createCommand($sql)
                ->bindValue(':description', $description)
                ->bindValue(':code', $code)
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $sql = "
        SELECT * 
        FROM point_types";
        $point_types = $db_old->createCommand($sql)
            ->queryAll();
        $sql = "
        INSERT INTO public.point_types 
        (description, code, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:description, :code, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($point_types as $type) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            switch ($type['id_pnt_type']) {
                case 1:
                    $code = 'uik_type_k';

                    break;
                case 2:
                    $code = 'uik_type_m';

                    break;
                case 3:
                    $code = 'light_trap';

                    break;
            }
            \Yii::$app->db->createCommand($sql)
                ->bindValue(':description', $type['pnt_type'])
                ->bindValue(':code', $code)
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $sql = "
        SELECT * FROM poisoncalc ORDER BY id";
        $poisoncalc = $db_old->createCommand($sql)
            ->queryAll();

        $sql = "
        INSERT INTO public.disinfectant 
        (description, code, value, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:description, :code, :value, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($poisoncalc as $poison) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));

            switch ($poison['id']) {
                case 1:
                    $code = 'rattidion';

                    break;
                case 2:
                    $code = 'indan-block';

                    break;
                case 3:
                    $code = 'shturm_granuly';

                    break;
                case 4:
                    $code = 'shturm_brickety';

                    break;
                case 5:
                    $code = 'alt-klej';

                    break;
            }
            $poison['pvalue'] = floatval(str_replace('руб', '', $poison['pvalue']));

            \Yii::$app->db->createCommand($sql)
                ->bindValue(':description', $poison['pname'])
                ->bindValue(':code', $code)
                ->bindValue(':value', $poison['pvalue'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $sql_insert = "
        INSERT INTO public.events
        (id_disinfector, id_customer, id_external, id_point_status, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:id_disinfector, :id_customer, :id_external, :id_point_status, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($companies as $company) {
            $name_table = $company['tbl_names'];
            if ($name_table == "PepsiCo_Sam") {
                $name_table = "\"PepsiCo_Sam\"";
            }
            if ($name_table == "Alpla_spb") {
                $name_table = "\"Alpla_spb\"";
            }
            if ($name_table == "Baltika_Spb") {
                $name_table = "\"Baltika_Spb\"";
            }
            if ($name_table == "Globus") {
                $name_table = "\"Globus\"";
            }
            $sql = "SELECT * FROM {$name_table}";
            $events = $db_old->createCommand($sql)
                ->queryAll();
            foreach ($events as $event) {
                if (!isset($event['created'])) {
                    $event['created'] = $event['Created'];
                }
                $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(new DateTime($event['created']));
                if ($event['executor'] == 666
                    or $event['executor'] == 110
                    or $event['executor'] == 0) {
                    continue;
                }
                if ($event['executor'] == 777) {
                    $event['executor'] = 14;
                }
                //2018-01-11 10:00:45+03
                if ($event['pointNum'] == 1
                    && $name_table == "baltika"
                    && $event['created'] == '2018-01-11 10:00:45+03') {
                    $index = 0;
                }
                $event['pointProp']++;
                $event['company']++;
                //$event['pointNum']++;
                \Yii::$app->db->createCommand($sql_insert)
                    ->bindValue(':id_disinfector', $event['executor'])
                    ->bindValue(':id_customer', $event['company'])
                    ->bindValue(':id_external', $event['pointNum'])
                    ->bindValue(':id_point_status', $event['pointProp'])
                    ->bindValue(':created_at', $created_at)
                    ->bindValue(':created_by', $created_by)
                    ->bindValue(':updated_at', $updated_at)
                    ->bindValue(':updated_by', $updated_by)
                    ->query();
            }
        }

        $this->stdout('Данные успешно перенесены' . PHP_EOL, Console::FG_GREEN);
    }
}
