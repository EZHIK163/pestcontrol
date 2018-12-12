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
            'hash'          => 'string',
            'size'          => 'string',
            'id_extension'  => 'integer',
            'mime_type'     => 'string',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->createTable('files.types', [
            'id'                        => 'pk',
            'is_active'                 => 'boolean DEFAULT true',
            'description'               => 'string',
            'code'                      => 'string',
            'path_to_folder'            => 'string',
            'created_at'                => 'integer',
            'created_by'                => 'integer',
            'updated_at'                => 'integer',
            'updated_by'                => 'integer'
        ]);

        $this->addForeignKey(
            'files_created_by',
            'files.files',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'files_updated_by',
            'files.files',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'types_created_by',
            'files.types',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'types_updated_by',
            'files.types',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->createTable('files.extension', [
            'id'                        => 'pk',
            'is_active'                 => 'boolean DEFAULT true',
            'description'               => 'string',
            'extension'                 => 'string',
            'id_type'                   => 'integer',
            'created_at'                => 'integer',
            'created_by'                => 'integer',
            'updated_at'                => 'integer',
            'updated_by'                => 'integer'
        ]);

        $this->addForeignKey(
            'extension_created_by',
            'files.extension',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'extension_updated_by',
            'files.extension',
            'updated_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'extension_id_type',
            'files.extension',
            'id_type',
            'files.types',
            'id'
        );

        $this->addForeignKey(
            'files_id_extension',
            'files.files',
            'id_extension',
            'files.extension',
            'id'
        );
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
        $this->dropForeignKey('extension_created_by', 'files.extension');
        $this->dropForeignKey('extension_updated_by', 'files.extension');
        $this->dropForeignKey('extension_id_type', 'files.extension');
        $this->dropForeignKey('files_id_extension', 'files.files');
        $this->dropTable('files.files');
        $this->dropTable('files.types');
        $this->dropTable('files.extension');

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
