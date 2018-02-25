<?php
namespace app\controllers;

use app\models\user\UserRecord;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller {
    public function actionIndex() {
        $users = $this->getUsers();
        $records = $this->wrapIntoDataProvider($users);
        return $this->render('userList', compact('records'));
    }

    private function wrapIntoDataProvider($data) {
        return new ArrayDataProvider([
            'allModels'     => $data,
            'pagination'    => false
        ]);
    }

    private function getUsers() {
        $user_records = UserRecord::find()->all();
        return $user_records;
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['index'],
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