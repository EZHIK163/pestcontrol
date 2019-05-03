<?php
namespace app\commands;

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда добавления типов файлов клиентов
 */
class AddFileCustomerTypesCommand extends Controller
{
    public function actionIndex()
    {
        $file_customer_type = new \app\entities\FileCustomerTypeRecord();
        $file_customer_type->description = 'Рекомендации';
        $file_customer_type->code = 'recommendations';
        $file_customer_type->save();

        $file_customer_type = new \app\entities\FileCustomerTypeRecord();
        $file_customer_type->description = 'Схемы контрольных точек';
        $file_customer_type->code = 'scheme_point_control';
        $file_customer_type->save();

        $this->stdout('Информация о типах файлов добавлена' . PHP_EOL, Console::FG_GREEN);
    }
}
