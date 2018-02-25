<?php
namespace app\controllers;

use app\models\user\LoginForm;
use app\models\user\UserRecord;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller {
    public function actionIndex() {
        if (!(\Yii::$app->user->isGuest)) {
            $this->redirect('account/index');
        }
        $model = new LoginForm();
        return $this->render('index', compact('model'));
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) and $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', compact('model'));
    }

    public function actionLogout() {
        \Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionCreate()
    {
        $user = new UserRecord();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->save();
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['login', 'logout'],
                'rules' => [
                    [
                        'actions'   => ['login'],
                        'roles'     => ['guest'],
                        'allow'     => true
                    ],
                    [
                        'actions'   => ['logout'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}