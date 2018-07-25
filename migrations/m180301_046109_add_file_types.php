<?php

use yii\db\Migration;

/**
 * Class m180303_114109_add_file_types
 */
class m180301_046109_add_file_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){

        $type = new \app\models\file\Types();

        $type->description = 'Офисные документы: doc, docx ...';
        $type->code = 'office';
        $type->path_to_folder = 'office/';

        $type->save();

        $type = new \app\models\file\Types();

        $type->description = 'Изображения: jpg, png, gif ...';
        $type->code = 'images';
        $type->path_to_folder = 'images/';

        $type->save();

        $extension = new \app\models\file\Extension();

        $extension->extension = 'docx';
        $extension->description = 'Файл MS Word 2007+ ';
        $extension->id_type = \app\models\file\Types::findOne(['code'    => 'office'])->id;

        $extension->save();

        $extension = new \app\models\file\Extension();

        $extension->extension = 'jpg';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = \app\models\file\Types::findOne(['code'    => 'images'])->id;

        $extension->save();

        $extension = new \app\models\file\Extension();

        $extension->extension = 'png';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = \app\models\file\Types::findOne(['code'    => 'images'])->id;

        $extension->save();

        $extension = new \app\models\file\Extension();

        $extension->extension = 'gif';
        $extension->description = 'Растровый графический формат';
        $extension->id_type = \app\models\file\Types::findOne(['code'    => 'images'])->id;

        $extension->save();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $type = \app\models\file\Extension::findOne(['extension' => 'docx']);
        $type->delete();

        $type = \app\models\file\Extension::findOne(['extension' => 'jpg']);
        $type->delete();

        $type = \app\models\file\Types::findOne(['code' => 'office']);
        $type->delete();

        $type = \app\models\file\Types::findOne(['code' => 'images']);
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
