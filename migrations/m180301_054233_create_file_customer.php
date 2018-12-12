<?php

use app\entities\UserRecord;
use yii\db\Migration;

/**
 * Class m180301_054233_create_scheme_point_control_and_recomendations
 */
class m180301_054233_create_file_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file_customer', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'id_file'       => 'integer',
            'id_customer'   => 'integer',
            'id_file_customer_type' => 'integer',
            'title'         => 'string',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->addForeignKey(
            'points_id_file_customer',
            'points',
            'id_file_customer',
            'file_customer',
            'id'
        );

        $this->addForeignKey(
            'file_customer_created_by',
            'file_customer',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'file_customer_updated_by',
            'file_customer',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'file_customer_id_file',
            'file_customer',
            'id_file',
            'files.files',
            'id'
        );

        $this->createTable('file_customer_type', [
            'id'                        => 'pk',
            'is_active'                 => 'boolean DEFAULT true',
            'description'               => 'string',
            'code'                      => 'string',
            'created_at'                => 'integer',
            'created_by'                => 'integer',
            'updated_at'                => 'integer',
            'updated_by'                => 'integer'
        ]);

        $this->addForeignKey(
            'file_customer_type_created_by',
            'file_customer_type',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'file_customer_type_updated_by',
            'file_customer_type',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'file_customer_id_file_customer_type',
            'file_customer',
            'id_file_customer_type',
            'file_customer_type',
            'id'
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('file_customer_created_by', 'file_customer');

        $this->dropForeignKey('file_customer_updated_by', 'file_customer');

        $this->dropForeignKey('file_customer_id_file', 'file_customer');

        $this->dropForeignKey('file_customer_type_created_by', 'file_customer_type');

        $this->dropForeignKey('file_customer_type_updated_by', 'file_customer_type');

        $this->dropForeignKey('file_customer_id_file_customer_type', 'file_customer');

        $this->dropTable('file_customer_type');

        $this->dropTable('file_customer');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180301_054233_create_scheme_point_control_and_recomendations cannot be reverted.\n";

        return false;
    }
    */
}
