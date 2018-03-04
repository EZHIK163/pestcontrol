<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\FileCustomer;
use app\models\customer\FileCustomerType;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\widget\Widget;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class ManagerController extends Controller {

    public function actionUsers() {
        return $this->render('userList', User::getUsersForAdmin());
    }

    public function actionUploadFiles() {

        $model = new UploadForm();

        if (\Yii::$app->request->isPost) {
            $model->uploadedFiles = UploadedFile::getInstances($model, 'uploadedFiles');
            $model->id_customer = \Yii::$app->request->post('UploadForm')['id_customer'];
            $model->id_file_customer_type = \Yii::$app->request->post('UploadForm')['id_file_customer_type'];
            if ($model->upload()) {
                $count = count($model->uploadedFiles);
                return $this->render('success_upload_files', compact('count'));
            }
        }

        $file_customer_types = FileCustomerType::getFileCustomerTypesForDropDownList();

        $customers = Customer::getCustomerForDropDownList();

        return $this->render('upload_files', compact('model', 'file_customer_types', 'customers'));
    }

    public function actionRecommendations() {
        $recommendations = FileCustomer::getRecommendations();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['users', 'upload-files'],
                'rules' => [
                    [
                        'controllers'   => ['manager'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }

}