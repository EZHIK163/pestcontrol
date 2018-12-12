<?php

use app\entities\UserRecord;
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
        $guest->description = 'Гость';
        $rbac->add($guest);

        $customer = $rbac->createRole('customer');
        $customer->description = 'Клиент фирмы';
        $rbac->add($customer);

        $admin = $rbac->createRole('admin');
        $admin->description = 'Админ сайта';
        $rbac->add($admin);

        $manager = $rbac->createRole('manager');
        $manager->description = 'Менеджер сайта';
        $rbac->add($manager);

        $rbac->addChild($admin, $manager);
        $rbac->addChild($manager, $customer);
        $rbac->addChild($customer, $guest);

        $user = new UserRecord();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->save();

        $user = new UserRecord();
        $user->username = 'manager';
        $user->password = 'manager';
        $user->save();

        $user = new UserRecord();
        $user->username = 'customer';
        $user->password = 'customer';
        $user->save();

        $user = new UserRecord();
        $user->username = 'PepsiCo_Sam';
        $user->password = 'gg15hj';
        $user->save();

        $rbac->assign(
            $admin,
            UserRecord::findOne(['username'    => 'admin'])->id
        );

        $rbac->assign(
            $manager,
            UserRecord::findOne(['username'    => 'manager'])->id
        );

        $rbac->assign(
            $customer,
            UserRecord::findOne(['username'    => 'customer'])->id
        );

        $rbac->assign(
            $customer,
            UserRecord::findOne(['username'    => 'PepsiCo_Sam'])->id
        );

        return true;
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
