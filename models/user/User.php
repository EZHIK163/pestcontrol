<?php

namespace app\models\user;

class User {

    public $login;

    public $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }
}