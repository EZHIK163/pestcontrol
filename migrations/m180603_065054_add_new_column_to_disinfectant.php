<?php

use yii\db\Migration;

/**
 * Class m180603_065054_add_new_column_to_disinfectant
 */
class m180603_065054_add_new_column_to_disinfectant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('disinfectant', 'form_of_facility', 'string');

        $this->addColumn('disinfectant', 'active_substance', 'string');

        $this->addColumn('disinfectant', 'concentration_of_substance', 'string');

        $this->addColumn('disinfectant', 'manufacturer', 'string');

        $this->addColumn('disinfectant', 'terms_of_use', 'string');

        $this->addColumn('disinfectant', 'place_of_application', 'string');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('disinfectant', 'form_of_facility');

        $this->dropColumn('disinfectant', 'active_substance');

        $this->dropColumn('disinfectant', 'concentration_of_substance');

        $this->dropColumn('disinfectant', 'manufacturer');

        $this->dropColumn('disinfectant', 'terms_of_use');

        $this->dropColumn('disinfectant', 'place_of_application');


        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180603_065054_add_newcolumnto_disinfectant_ cannot be reverted.\n";

        return false;
    }
    */
}
