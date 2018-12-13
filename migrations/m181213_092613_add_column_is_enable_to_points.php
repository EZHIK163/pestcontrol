<?php

use yii\db\Migration;

/**
 * Class m181213_092613_add_column_is_enable_to_points
 */
class m181213_092613_add_column_is_enable_to_points extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('public.points', 'is_enable', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.points', 'is_enable');

        return true;
    }

}
