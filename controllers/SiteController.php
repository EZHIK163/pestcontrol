<?php
namespace app\controllers;

use app\models\file\Files;
use app\models\user\LoginForm;
use app\models\widget\Widget;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller {
    public function actionIndex() {
        if (!(\Yii::$app->user->isGuest)) {
            $this->redirect('account/index');
        }
        $model = new LoginForm();

        $widget = Widget::getSiteWidget();

        return $this->render('index', compact('model', 'widget'));
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

    public function actionDownload() {
        $id = \Yii::$app->request->get('id');
        $file = Files::getInfoForDownloadById($id);
        $url = $file['url'];
        $name = $file['name'];

        if (file_exists($url)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($url));
            // читаем файл и отправляем его пользователю
            readfile($url);
            exit;
        } else {
            exit;
        }
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
                        'roles'     => ['?'],
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