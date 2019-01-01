<?php

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use yii\db\Migration;

/**
 * Class m180303_114109_add_file_types
 */
class m180301_046109_add_file_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $type = new ExtensionTypeRecord();

        $type->description = 'Офисные документы: doc, docx ...';
        $type->code = 'office';
        $type->path_to_folder = 'office/';

        $type->save();

        $type = new ExtensionTypeRecord();

        $type->description = 'Изображения: jpg, png, gif ...';
        $type->code = 'images';
        $type->path_to_folder = 'images/';

        $type->save();

        $extension = new FileExtensionRecord();

        $extension->extension = 'docx';
        $extension->description = 'Файл MS Word 2007+ ';
        $extension->id_type = ExtensionTypeRecord::findOne(['code'    => 'office'])->id;

        $extension->save();

        $extension = new FileExtensionRecord();

        $extension->extension = 'jpg';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = ExtensionTypeRecord::findOne(['code'    => 'images'])->id;

        $extension->save();

        $extension = new FileExtensionRecord();

        $extension->extension = 'png';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = ExtensionTypeRecord::findOne(['code'    => 'images'])->id;

        $extension->save();

        $extension = new FileExtensionRecord();

        $extension->extension = 'gif';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = ExtensionTypeRecord::findOne(['code'    => 'images'])->id;

        $extension->save();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $type = FileExtensionRecord::findOne(['extension' => 'docx']);
        $type->delete();

        $type = FileExtensionRecord::findOne(['extension' => 'jpg']);
        $type->delete();

        $type = ExtensionTypeRecord::findOne(['code' => 'office']);
        $type->delete();

        $type = ExtensionTypeRecord::findOne(['code' => 'images']);
        $type->delete();

        return true;
    }


    // Use up()/down() to run migration code without a transaction.
   /* public function up()
    {

    }

    public function down()
    {


        return false;
    }*/
}
