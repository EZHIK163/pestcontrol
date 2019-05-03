<?php
namespace app\commands;

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда добавления дез. средств клиентам
 */
class SetDisinfectantCustomersCommand extends Controller
{
    public function actionIndex()
    {
        $customers = \app\entities\CustomerRecord::find()->asArray()->all();
        foreach ($customers as $customer) {
            $c_d = new \app\entities\CustomerDisinfectantRecord();
            $c_d->id_customer = $customer['id'];
            $c_d->id_disinfectant = 1;
            $c_d->save();

            $c_d = new \app\entities\CustomerDisinfectantRecord();
            $c_d->id_customer = $customer['id'];
            $c_d->id_disinfectant = 2;
            $c_d->save();

            $c_d = new \app\entities\CustomerDisinfectantRecord();
            $c_d->id_customer = $customer['id'];
            $c_d->id_disinfectant = 3;
            $c_d->save();

            $c_d = new \app\entities\CustomerDisinfectantRecord();
            $c_d->id_customer = $customer['id'];
            $c_d->id_disinfectant = 4;
            $c_d->save();

            $c_d = new \app\entities\CustomerDisinfectantRecord();
            $c_d->id_customer = $customer['id'];
            $c_d->id_disinfectant = 5;
            $c_d->save();
        }

        $this->stdout('Дез. средства добавлены клиентам' . PHP_EOL, Console::FG_GREEN);
    }
}
