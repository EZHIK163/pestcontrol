<?php
namespace app\models\user;

use app\entities\CustomerRecord;
use app\models\user\UserRecord;
use yii\base\Model;

class UserForm extends Model {
    public $id;
    public $username;
    public $password;
    public $role;
    public $id_customer;

    public function rules()
    {
        return [
            ['id', 'number'],
            ['username', 'required'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'max' => 256],
            ['id_customer', 'required'],
            ['role', 'required']
        ];
    }

    public function fetchUser($id) {
        $user = UserRecord::getUserById($id);
        $this->username = $user->username;
        $id_customer = isset($user->customer->id) ? $user->customer->id : null;
        $this->id_customer = $id_customer;
        $this->id = $user->id;

        $rbac = \Yii::$app->authManager;
        $role = $rbac->getRoleByUser($user->id)->name;
        $this->role = $role;

    }

    public function saveUser() {
        $user = UserRecord::getUserById($this->id);
        $user->username = $this->username;

        CustomerRecord::setIdUserOwner($this->id_customer, $this->id);

        $rbac = \Yii::$app->authManager;
        $current_role = $rbac->getRoleByUser($user->id)->name;
        $role = $rbac->getRole($current_role);
        $rbac->revoke($role, $user->id);

        $role = $rbac->getRole($this->role);
        $rbac->assign($role, $user->id);

        $user->save();
    }

    public function addUser() {
        $user = new UserRecord();
        $user->username = $this->username;
        $user->password = $this->password;
        $user->save();

        CustomerRecord::setIdUserOwner($this->id_customer, $user->id);

        $rbac = \Yii::$app->authManager;
        $role = $rbac->getRole($this->role);
        $rbac->assign($role, $user->id);
    }

}