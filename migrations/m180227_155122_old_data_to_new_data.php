<?php

use app\entities\UserRecord;
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
        $this->dropTable('customers');

        $this->createTable(
            'customers',
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

        $this->addForeignKey(
            'customer_created_by',
            'customers',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'customer_updated_by',
            'customers',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'customer_id_user_owner',
            'customers',
            'id_user_owner',
            'auth.users',
            'id'
        );

        $this->createTable(
            'disinfectors',
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

        $this->addForeignKey(
            'disinfector_created_by',
            'disinfectors',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'disinfector_updated_by',
            'disinfectors',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable(
            'point_status',
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

        $this->addForeignKey(
            'point_status_created_by',
            'point_status',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'point_status_updated_by',
            'point_status',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable(
            'point_types',
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

        $this->addForeignKey(
            'point_types_created_by',
            'point_types',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'point_types_updated_by',
            'point_types',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable(
            'disinfectant',
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

        $this->addForeignKey(
            'disinfectant_created_by',
            'disinfectant',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'disinfectant_updated_by',
            'disinfectant',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable(
            'points',
            [
                'id'                 => 'pk',
                'is_active'          => 'boolean DEFAULT true',
                'id_file_customer'   => 'integer',
                'id_internal'        => 'integer',
                'id_point_status'    => 'integer',
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

        $this->addForeignKey(
            'points_id_point_status',
            'points',
            'id_point_status',
            'point_status',
            'id'
        );

        $this->addForeignKey(
            'points_types_created_by',
            'points',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'points_types_updated_by',
            'points',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable(
            'events',
            [
                'id'                    => 'pk',
                'is_active'             => 'boolean DEFAULT true',
                'id_customer'           => 'integer',
                'id_disinfector'        => 'integer',
                'id_external'           => 'integer',
                'id_point'              => 'integer',
                'id_point_status'       => 'integer',
                'created_at'            => 'integer',
                'created_by'            => 'integer',
                'updated_at'            => 'integer',
                'updated_by'            => 'integer'
            ]
        );

        $this->addForeignKey(
            'events_id_point_status',
            'events',
            'id_point_status',
            'point_status',
            'id'
        );

        $this->addForeignKey(
            'events_id_disinfector',
            'events',
            'id_disinfector',
            'disinfectors',
            'id'
        );

        $this->addForeignKey(
            'events_id_point',
            'events',
            'id_point',
            'points',
            'id'
        );

        $this->addForeignKey(
            'events_id_customer',
            'events',
            'id_customer',
            'customers',
            'id'
        );

        $this->addForeignKey(
            'events_created_by',
            'events',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'events_updated_by',
            'events',
            'updated_by',
            'auth.users',
            'id'
        );

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
}
