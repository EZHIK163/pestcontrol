<?php

use yii\db\Migration;

/**
 * Class m180509_174118_create_customer_disinfectants
 */
class m180509_174118_create_customer_disinfectants extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('customer_disinfectant', [
            'id'                => 'pk',
                'is_active'     => 'boolean DEFAULT true',
            'id_customer'       => 'integer',
            'id_disinfectant'   => 'integer',
            'created_at'        => 'integer',
            'created_by'        => 'integer',
            'updated_at'        => 'integer',
            'updated_by'        => 'integer'
        ]);

        $this->addForeignKey(
            'customer_disinfectant_id_customer',
            'customer_disinfectant',
            'id_customer',
            'customers',
            'id'
        );

        $this->addForeignKey(
            'customer_disinfectant_id_disinfectant',
            'customer_disinfectant',
            'id_disinfectant',
            'disinfectant',
            'id'
        );

        $this->addForeignKey(
            'customer_disinfectant_contact_created_by',
            'customer_disinfectant',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'customer_disinfectant_updated_by',
            'customer_disinfectant',
            'updated_by',
            'auth.users',
            'id'
        );

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
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customer_disinfectant');

        $this->dropForeignKey('customer_disinfectant_id_customer', 'customer_disinfectant');

        $this->dropForeignKey('customer_disinfectant_id_disinfectant', 'customer_disinfectant');

        $this->dropForeignKey('customer_disinfectant_contact_created_by', 'customer_disinfectant');

        $this->dropForeignKey('customer_disinfectant_updated_by', 'customer_disinfectant');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180509_174118_create_customer_disinfectants cannot be reverted.\n";

        return false;
    }
    */
}
