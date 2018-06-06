<?php

use app\models\user\UserRecord;
use yii\db\Connection;
use yii\db\Migration;
use yii\di\Instance;

/**
 * Class m180227_155122_old_data_to_new_data
 */
class m180227_155122_old_data_to_new_data extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db_old = Instance::ensure('db_old', Connection::class);
        $db_old->getSchema()->refresh();
        $db_old->enableSlaves = false;

        $this->dropTable('customers');

        $this->createTable('customers',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'id_user_owner' => 'integer',
                'name'          => 'string',
                'code'          => 'string',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('customer_created_by', 'customers',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('customer_updated_by', 'customers',
            'updated_by', 'auth.users', 'id');

        $this->addForeignKey('customer_id_user_owner', 'customers',
            'id_user_owner', 'auth.users', 'id');

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
            $this->db->createCommand($sql)
                ->bindValue(':name', $company['name'])
                ->bindValue(':code', $company['tbl_names'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
            ->query();
        }

        $this->createTable('disinfectors',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'full_name'     => 'string',
                'phone'         => 'string',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('disinfector_created_by', 'disinfectors',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('disinfector_updated_by', 'disinfectors',
            'updated_by', 'auth.users', 'id');

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
            $this->db->createCommand($sql)
                ->bindValue(':full_name', $disinfector['des_fio'])
                ->bindValue(':phone', $disinfector['des_tel'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $this->createTable('point_status',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'description'   => 'string',
                'code'          => 'string',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('point_status_created_by', 'point_status',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('point_status_updated_by', 'point_status',
            'updated_by', 'auth.users', 'id');

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
            switch($point['stt_id']) {
                case 0:
                    $code = 'not_touch';
                    break;
                case 1:
                    $code = 'part_replace';
                    break;
                case 2:
                    $code = 'full_replace';
                    break;
                case 3:
                    $code = 'caught';
                    break;
            }
            $this->db->createCommand($sql)
                ->bindValue(':description', $point['stt_name'])
                ->bindValue(':code', $code)
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $this->createTable('point_types',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'description'   => 'string',
                'code'          => 'string',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('point_types_created_by', 'point_types',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('point_types_updated_by', 'point_types',
            'updated_by', 'auth.users', 'id');

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
            switch($type['id_pnt_type']) {
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
            $this->db->createCommand($sql)
                ->bindValue(':description', $type['pnt_type'])
                ->bindValue(':code', $code)
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $this->createTable('disinfectant',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'description'   => 'string',
                'code'          => 'string',
                'value'         => 'string',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('disinfectant_created_by', 'disinfectant',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('disinfectant_updated_by', 'disinfectant',
            'updated_by', 'auth.users', 'id');

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

            switch($poison['id']) {
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

            $this->db->createCommand($sql)
                ->bindValue(':description', $poison['pname'])
                ->bindValue(':code', $code)
                ->bindValue(':value', $poison['pvalue'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }


        $this->createTable('points',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'id_file_customer'   => 'integer',
                'id_internal'   => 'integer',
                'id_point_status' => 'integer',
                //'pnt_map'     => '',
                'title'         => 'string',
                //'activity'      => 'boolean',
                'x_coordinate'  => 'float',
                'y_coordinate'  => 'float',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('points_id_point_status', 'points',
            'id_point_status', 'point_status', 'id');



        $this->addForeignKey('points_types_created_by', 'points',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('points_types_updated_by', 'points',
            'updated_by', 'auth.users', 'id');

//        $sql = "
//        SELECT *
//        FROM points";
//        $points = $db_old->createCommand($sql)
//            ->queryAll();
//        $sql = "
//        INSERT INTO public.points
//        (id_customer, id_point_status, title, x_coordinate, y_coordinate, created_at, created_by, updated_at, updated_by)
//        VALUES
//        (:id_customer, :id_point_status, :title, :x_coordinate, :y_coordinate,  :created_at, :created_by, :updated_at, :updated_by)";
//
//        foreach ($points as $point) {
//            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
//
//            $point['id_pnt_type']++;
//            $this->db->createCommand($sql)
//                ->bindValue(':id_customer', $point['id_comp'])
//                ->bindValue(':id_point_status', $point['id_pnt_type'])
//                ->bindValue(':title', $point['pnt_title'])
//                ->bindValue(':x_coordinate', $point['pnt_loc_x'])
//                ->bindValue(':y_coordinate', $point['pnt_loc_y'])
//                ->bindValue(':created_at', $created_at)
//                ->bindValue(':created_by', $created_by)
//                ->bindValue(':updated_at', $updated_at)
//                ->bindValue(':updated_by', $updated_by)
//                ->query();
//        }

        $this->createTable('events',
            [
                'id'                    => 'pk',
                'is_active'             => 'boolean DEFAULT true',
                'id_customer'           => 'integer',
                'id_disinfector'        => 'integer',
                'id_external'           => 'integer',
                'id_point'              => 'integer',
                'id_point_status'       => 'integer',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey('events_id_point_status', 'events',
            'id_point_status', 'point_status', 'id');

        $this->addForeignKey('events_id_disinfector', 'events',
            'id_disinfector', 'disinfectors', 'id');

        $this->addForeignKey('events_id_point', 'events',
            'id_point', 'points', 'id');

        $this->addForeignKey('events_id_customer', 'events',
            'id_customer', 'customers', 'id');

        $this->addForeignKey('events_created_by', 'events',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('events_updated_by', 'events',
            'updated_by', 'auth.users', 'id');


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
                if ($event['pointProp'] == 3 && $name_table == "\"Alpla_spb\"") {
                    $index = 0;
                }
                $event['pointProp']++;
                $event['pointNum']++;
                $this->db->createCommand($sql_insert)
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
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('events_updated_by', 'events');
        $this->dropForeignKey('events_created_by', 'events');
        $this->dropForeignKey('events_id_customer', 'events');
        $this->dropForeignKey('events_id_disinfector', 'events');
        $this->dropForeignKey('events_id_point_status', 'events');
        $this->dropForeignKey('points_types_updated_by', 'points');
        $this->dropForeignKey('points_types_created_by', 'points');
        $this->dropForeignKey('points_id_customer', 'points');
        $this->dropForeignKey('points_id_point_status', 'points');
        $this->dropForeignKey('point_types_updated_by', 'point_types');
        $this->dropForeignKey('point_types_created_by', 'point_types');
        $this->dropForeignKey('point_status_updated_by', 'point_status');
        $this->dropForeignKey('point_status_created_by', 'point_status');
        $this->dropForeignKey('disinfector_updated_by', 'disinfectors');
        $this->dropForeignKey('disinfector_created_by', 'disinfectors');
        $this->dropForeignKey('customer_updated_by', 'customers');
        $this->dropForeignKey('customer_created_by', 'customers');
        $this->dropForeignKey('disinfectant_created_by', 'disinfectant');
        $this->dropForeignKey('disinfectant_updated_by', 'disinfectant');

        $this->dropTable('disinfectant');
        $this->dropTable('points');
        $this->dropTable('events');
        $this->truncateTable('customers');
        $this->dropTable('disinfectors');
        $this->dropTable('point_status');
        $this->dropTable('point_types');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180227_155122_old_data_to_new_data cannot be reverted.\n";

        return false;
    }
    */
}
