<?php

use app\entities\UserRecord;
use yii\db\Migration;

/**
 * Class m180913_065534_add_new_point_status
 */
class m180913_065534_add_new_point_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "
        INSERT INTO public.point_status 
        (description, code, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:description, :code, :created_at, :created_by, :updated_at, :updated_by)";

        $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));

        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;

        $code = 'caught_nagetier';
        $description = 'Пойман вредитель: грызун';

        $this->db->createCommand($sql)
            ->bindValue(':description', $description)
            ->bindValue(':code', $code)
            ->bindValue(':created_at', $created_at)
            ->bindValue(':created_by', $created_by)
            ->bindValue(':updated_at', $updated_at)
            ->bindValue(':updated_by', $updated_by)
            ->query();

        $code = 'caught_insekt';
        $description = 'Пойман вредитель: насекомое';

        $this->db->createCommand($sql)
            ->bindValue(':description', $description)
            ->bindValue(':code', $code)
            ->bindValue(':created_at', $created_at)
            ->bindValue(':created_by', $created_by)
            ->bindValue(':updated_at', $updated_at)
            ->bindValue(':updated_by', $updated_by)
            ->query();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180913_065534_add_new_point_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180913_065534_add_new_point_status cannot be reverted.\n";

        return false;
    }
    */
}
