<?php
namespace app\commands;

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда добавления информации о расширении файлов
 */
class AddExtensionInfoCommand extends Controller
{
    public function actionIndex()
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

        $this->stdout('Информация о расширениях добавлена' . PHP_EOL, Console::FG_GREEN);
    }
}
