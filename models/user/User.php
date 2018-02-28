<?php

namespace app\models\user;

use app\models\tools\Tools;

class User {

    public $login;

    public $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public static function getUsersForAdmin() {
        $records = Tools::wrapIntoDataProvider(UserRecord::find()->all());
        return compact('records');
    }
}