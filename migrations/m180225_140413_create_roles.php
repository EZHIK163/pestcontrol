<?php

use yii\db\Migration;

/**
 * Class m180225_140413_create_roles
 */
class m180225_140413_create_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rbac = Yii::$app->authManager;

        $guest = $rbac->createRole('guest');
        $guest->description = 'Nobody';
        $rbac->add($guest);

        $customer = $rbac->createRole('customer');
        $customer->description = 'Клиент фирмы';
        $rbac->add($customer);

        $admin = $rbac->createRole('admin');
        $admin->description = 'Админ сайта';
        $rbac->add($admin);

        $rbac->addChild($admin, $customer);
        $rbac->addChild($customer, $guest);

        $rbac->assign($admin,
            \app\models\user\UserRecord::findOne(['username'    => 'admin'])->id
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180225_140413_create_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180225_140413_create_roles cannot be reverted.\n";

        return false;
    }
    */
}
