<?php

use yii\db\Migration;

/**
 * Class m180603_070043_fill_new_column_disinfectant
 */
class m180603_070043_fill_new_column_disinfectant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $disinfectant = \app\models\customer\Disinfectant::findOne(['code'  => 'alt-klej']);
        $disinfectant->form_of_facility = 'клеевая масса';
        $disinfectant->active_substance = 'не токсично';
        $disinfectant->concentration_of_substance = '';
        $disinfectant->manufacturer = 'ООО Валбрента кемикалс';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения';
        $disinfectant->save();

        $disinfectant = \app\models\customer\Disinfectant::findOne(['code'  => 'rattidion']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'бромадиалон';
        $disinfectant->concentration_of_substance = '0,25%';
        $disinfectant->manufacturer = 'ООО Валбрента кемикалс';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\models\customer\Disinfectant::findOne(['code'  => 'shturm_granuly']);
        $disinfectant->form_of_facility = 'гранулированая форма';
        $disinfectant->active_substance = 'бродифакум';
        $disinfectant->concentration_of_substance = '0,005%';
        $disinfectant->manufacturer = 'ГАРАНТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\models\customer\Disinfectant::findOne(['code'  => 'indan-block']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'тетрафенацин';
        $disinfectant->concentration_of_substance = '0,01%';
        $disinfectant->manufacturer = 'РЭТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();

        $disinfectant = \app\models\customer\Disinfectant::findOne(['code'  => 'shturm_brickety']);
        $disinfectant->form_of_facility = 'парафинированные брикеты';
        $disinfectant->active_substance = 'бродифакум';
        $disinfectant->concentration_of_substance = '0,005%';
        $disinfectant->manufacturer = 'ГАРАНТ Россия';
        $disinfectant->terms_of_use = 'Закладка в приманочные контейнеры';
        $disinfectant->place_of_application = 'Помещения и открытые станции';
        $disinfectant->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180603_070043_fill_new_column_disinfectant cannot be reverted.\n";

        return false;
    }
    */
}
