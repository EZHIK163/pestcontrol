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
                'name'          => 'string',
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

        $sql = "
        SELECT * 
        FROM company_names";
        $companies = $db_old->createCommand($sql)
            ->queryAll();
        $sql = "
        INSERT INTO public.customers 
        (name, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:name, :created_at, :created_by, :updated_at, :updated_by)";
        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;
        foreach ($companies as $company) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            $this->db->createCommand($sql)
                ->bindValue(':name', $company['name'])
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

        $this->createTable('points',
            [
                'id'            => 'pk',
                'is_active'     => 'boolean DEFAULT true',
                'id_customer'   => 'integer',
                'id_point_type' => 'integer',
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

        $this->addForeignKey('points_id_point_type', 'points',
            'id_point_type', 'point_types', 'id');

        $this->addForeignKey('points_id_customer', 'points',
            'id_customer', 'customers', 'id');

        $this->addForeignKey('points_types_created_by', 'point_types',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('points_types_updated_by', 'point_types',
            'updated_by', 'auth.users', 'id');

        $sql = "
        SELECT * 
        FROM points";
        $points = $db_old->createCommand($sql)
            ->queryAll();
        $sql = "
        INSERT INTO public.points 
        (id_customer, id_point_type, title, x_coordinate, y_coordinate, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:id_customer, :id_point_type, :title, :x_coordinate, :y_coordinate,  :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($points as $point) {
            $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            if ($point['id_pnt_type'] == 0) {
                continue;
            }
            $this->db->createCommand($sql)
                ->bindValue(':id_customer', $point['id_comp'])
                ->bindValue(':id_point_type', $point['id_pnt_type'])
                ->bindValue(':title', $point['pnt_title'])
                ->bindValue(':x_coordinate', $point['pnt_loc_x'])
                ->bindValue(':y_coordinate', $point['pnt_loc_y'])
                ->bindValue(':created_at', $created_at)
                ->bindValue(':created_by', $created_by)
                ->bindValue(':updated_at', $updated_at)
                ->bindValue(':updated_by', $updated_by)
                ->query();
        }

        $this->createTable('events',
            [
                'id'                    => 'pk',
                'is_active'             => 'boolean DEFAULT true',
                'id_customer'           => 'integer',
                'id_disinfector'        => 'integer',
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

        $this->addForeignKey('events_id_point', 'events',
            'id_point', 'points', 'id');

        $this->addForeignKey('events_id_disinfector', 'events',
            'id_disinfector', 'disinfectors', 'id');

        $this->addForeignKey('events_id_customer', 'events',
            'id_customer', 'customers', 'id');

        $this->addForeignKey('events_created_by', 'events',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('events_updated_by', 'events',
            'updated_by', 'auth.users', 'id');


        $sql_insert = "
        INSERT INTO public.events
        (id_disinfector, id_customer, id_point, id_point_status, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:id_disinfector, :id_customer, :id_point, :id_point_status, :created_at, :created_by, :updated_at, :updated_by)";

        foreach ($companies as $company) {
            $name_table = $company['tbl_names'];
            $sql = "SELECT * FROM {$name_table}";
            $events = $db_old->createCommand($sql)
                ->queryAll();
            foreach ($events as $event) {
                $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
                if ($event['executor'] == 666) {
                    continue;
                }
                if ($event['executor'] == 777) {
                    $event['executor'] = 14;
                }
                $event['pointProp']++;
                $this->db->createCommand($sql_insert)
                    ->bindValue(':id_disinfector', $event['executor'])
                    ->bindValue(':id_customer', $event['company'])
                    ->bindValue(':id_point', $event['pointNum'])
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
        $this->truncateTable('customers');
        $this->dropTable('disinfectors');
        $this->dropTable('point_status');
        $this->dropTable('point_types');
        $this->dropTable('points');
        $this->dropTable('events');
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
