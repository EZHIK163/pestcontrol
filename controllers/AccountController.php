<?php
namespace app\controllers;

use app\models\widget\Widget;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountController extends Controller {


    public function actionIndex() {
        return $this->render('index', Widget::getWidgetsForAccount());
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['index'],
                'rules' => [
                    [
                        'actions'   => ['index'],
                        'roles'     => ['admin'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}