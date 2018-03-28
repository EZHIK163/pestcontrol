<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\CustomerForm;
use app\models\customer\FileCustomer;
use app\models\customer\FileCustomerType;
use app\models\file\Files;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\user\UserRecord;
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
                $action = $model->getViewAfterUpload();
                $this->redirect($action);
            }
        }

        $file_customer_types = FileCustomerType::getFileCustomerTypesForDropDownList();

        $customers = Customer::getCustomerForDropDownList();

        return $this->render('upload_files', compact('model', 'file_customer_types', 'customers'));
    }

    public function actionRecommendations() {
        $recommendations = FileCustomer::getRecommendationsForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    public function actionDeleteRecommendation() {
        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        Files::deleteFile($id);
        $this->redirect('recommendations');
    }

    public function actionSchemePointControl() {
        $scheme_point_control = FileCustomer::getSchemePointControlForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme-point-control', compact('data_provider'));
    }

    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

    public function actionCustomers() {
        $users = Customer::getCustomersForManager();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('customers', compact('data_provider'));
    }

    public function actionAddCustomer() {

        $model = new CustomerForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->addCustomer();
            $this->redirect('customers');
        }

        $users = UserRecord::getUsersForDropDownList();
        return $this->render('add-customer', compact('model', 'users'));
    }

    public function actionDeleteCustomer() {
        $id = \Yii::$app->request->get('id');
        if (isset($id)) {
            Customer::deleteCustomer($id);
            $this->redirect('customers');
        }
    }

    public function actionEditCustomer() {
        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new CustomerForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->saveCustomer();
            $this->redirect('customers');
        }

        $model->fetchCustomer($id);
        $users = UserRecord::getUsersForDropDownList();
        return $this->render('edit-customer', compact('model', 'users'));
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
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