<?php

use app\models\user\UserRecord;
use yii\db\Migration;

/**
 * Class m180301_054233_create_scheme_point_control_and_recomendations
 */
class m180301_054233_create_scheme_point_control_and_recomendations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('recommendations_for_customer', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'name'          => 'string',
            'id_file'       => 'integer',
            'id_customer'   => 'integer',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->addForeignKey('recommendations_for_customer_created_by', 'recommendations_for_customer',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('recommendations_for_customer_updated_by', 'recommendations_for_customer',
            'updated_by', 'auth.users', 'id');

        $this->addForeignKey('recommendations_for_customer_id_file', 'recommendations_for_customer',
            'id_file', 'files.files', 'id');

        $this->createTable('scheme_point_control', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'name'          => 'string',
            'id_file'       => 'integer',
            'id_customer'   => 'integer',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->addForeignKey('scheme_point_control_created_by', 'scheme_point_control',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('scheme_point_control_updated_by', 'scheme_point_control',
            'updated_by', 'auth.users', 'id');

        $this->addForeignKey('scheme_point_control_id_file', 'scheme_point_control',
            'id_file', 'files.files', 'id');

        $type = new \app\models\file_type\FilesTypes();

        $type->description = 'Рекомендации в формате DOCX';
        $type->code = 'recommendations';

        $type->save();

        $type = new \app\models\file_type\FilesTypes();

        $type->description = 'Схемы точек контроля';
        $type->code = 'scheme_point_control';

        $type->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('recommendations_for_customer_created_by', 'recommendations_for_customer');
        $this->dropForeignKey('recommendations_for_customer_updated_by', 'recommendations_for_customer');
        $this->dropForeignKey('recommendations_for_customer_id_file', 'recommendations_for_customer');
        $this->dropForeignKey('scheme_point_control_created_by', 'scheme_point_control');
        $this->dropForeignKey('scheme_point_control_updated_by', 'scheme_point_control');
        $this->dropForeignKey('scheme_point_control_id_file', 'scheme_point_control');

        $this->dropTable('recommendations_for_customer');
        $this->dropTable('scheme_point_control');
        $this->truncateTable('files.types');

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
