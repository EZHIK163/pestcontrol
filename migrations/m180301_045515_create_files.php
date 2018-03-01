<?php

use yii\db\Migration;

/**
 * Class m180301_045515_create_files
 */
class m180301_045515_create_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE SCHEMA files";
        $this->db->createCommand($sql)->query();

        $this->createTable('files.files', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'original_name' => 'string',
            'path'          => 'string',
            'size'          => 'string',
            'extension'     => 'string',
            'mime_type'     => 'string',
            'id_type'       => 'integer',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->createTable('files.types', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'description'   => 'string',
            'code'          => 'string',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->addForeignKey('files_created_by', 'files.files',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('files_updated_by', 'files.files',
            'updated_by', 'auth.users', 'id');

        $this->addForeignKey('types_created_by', 'files.types',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('types_updated_by', 'files.types',
            'updated_by', 'auth.users', 'id');

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('files_created_by', 'files.files');
        $this->dropForeignKey('files_updated_by', 'files.files');
        $this->dropForeignKey('types_updated_by', 'files.types');
        $this->dropForeignKey('types_created_by', 'files.types');
        $this->dropTable('files.files');
        $this->dropTable('files.types');

        $sql = "DROP SCHEMA files CASCADE";
        $this->db->createCommand($sql)->query();
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180301_045515_create_files cannot be reverted.\n";

        return false;
    }
    */
}
