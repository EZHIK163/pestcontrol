<?php
namespace app\commands;

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда заполнения информации о дез. средствах
 */
class FillDisinfectantInfoCommand extends Controller
{
    public function actionIndex()
    {
        $disinfectant = \app\entities\DisinfectantRecord::findOne(['code'  => 'alt-klej']);
        $disinfectant->form_of_facility = 'клеевая масса';
        $disinfectant->active_substance = 'не токсично';
        $disinfectant->concentration_of_substance = '';
        $disinfectant->manufacturer = 'ООО Валбрента кемикалс';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения';
        $disinfectant->save();

        $disinfectant = \app\entities\DisinfectantRecord::findOne(['code'  => 'rattidion']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'бромадиалон';
        $disinfectant->concentration_of_substance = '0,25%';
        $disinfectant->manufacturer = 'ООО Валбрента кемикалс';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\entities\DisinfectantRecord::findOne(['code'  => 'shturm_granuly']);
        $disinfectant->form_of_facility = 'гранулированая форма';
        $disinfectant->active_substance = 'бродифакум';
        $disinfectant->concentration_of_substance = '0,005%';
        $disinfectant->manufacturer = 'ГАРАНТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\entities\DisinfectantRecord::findOne(['code'  => 'indan-block']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'тетрафенацин';
        $disinfectant->concentration_of_substance = '0,01%';
        $disinfectant->manufacturer = 'РЭТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\entities\DisinfectantRecord::findOne(['code'  => 'shturm_brickety']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'бродифакум';
        $disinfectant->concentration_of_substance = '0,005%';
        $disinfectant->manufacturer = 'ГАРАНТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $this->stdout('Информация о дез. средствах заполнена' . PHP_EOL, Console::FG_GREEN);
    }
}
