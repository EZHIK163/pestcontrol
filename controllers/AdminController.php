<?php
namespace app\controllers;

use app\models\user\User;
use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller {

    public function actionUsers() {
        return $this->render('userList', User::getUsersForAdmin());
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['users'],
                'rules' => [
                    [
                        'controllers'   => ['admin'],
                        'roles'     => ['admin'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }

}