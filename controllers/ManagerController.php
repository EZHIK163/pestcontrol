<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\CustomerForm;
use app\models\customer\Disinfectant;
use app\models\customer\FileCustomer;
use app\models\customer\FileCustomerType;
use app\models\customer\ManageDisinfectantsForm;
use app\models\customer\ManagePointsForm;
use app\models\customer\Points;
use app\models\customer\SearchForm;
use app\models\file\Files;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\user\UserRecord;
use app\models\widget\Widget;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

class ManagerController extends Controller {

    public function beforeAction($action)
    {
        if ($action->id == 'save-point') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

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

        $model = new SearchForm();

        if (\Yii::$app->request->isPost) {
            $model->query = \Yii::$app->request->post('SearchForm')['query'];
        }

        $scheme_point_control = $model->getResultsForAdmin();

        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme-point-control', compact('data_provider', 'model'));
    }

    public function actionEditSchemaPointControl() {
        $id_scheme_point_control = (int)\Yii::$app->request->get('id');
        if (!isset($id_scheme_point_control) or $id_scheme_point_control === 0) {
            throw new InvalidArgumentException();
        }
        return $this->render('edit-schema-point-control', compact('id_scheme_point_control'));
    }

    public function actionGetPointsOnSchemaPointControl() {
        $id_file = \Yii::$app->request->get('id_scheme_point_control');

        if (!isset($id_file) or $id_file === 0) {
            throw new InvalidArgumentException();
        }
//        $data[666] = [
//            'img'       => 'http://koffkindom.ru/wp-content/uploads/2016/02/plan-doma-8x8-2et-10.jpg',
//            'points'    => [
//                [
//                    'id'        => 'point_1',
//                    'x'         => 0,
//                    'y'         => 0,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ],
//                [
//                    'id'        => 'point_2',
//                    'x'         => 10,
//                    'y'         => 10,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ],
//                [
//                    'id'        => 'point_3',
//                    'x'         => 312,
//                    'y'         => 104,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ]
//            ]
//        ];
//        $my_data = $data[$id];
        $my_data = FileCustomer::getSchemeForEdit($id_file);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $my_data;
    }

    public function actionSavePoint() {

        $points = \Yii::$app->request->post('points');
        $id_file_customer = (int)\Yii::$app->request->post('id_file_customer');
        if (!isset($points) or $id_file_customer === 0) {
            throw new \yii\base\InvalidArgumentException();
        }
        FileCustomer::savePoints($id_file_customer, $points);

        $data = ['status'   => true];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
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


    public function actionManagePoints() {

        $model = new ManagePointsForm();

        $id_customer = null;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $id_customer = $model->id_customer;
        }

        $customers = Customer::getCustomerForDropDownList();

        $points = Points::getPointsForManager($id_customer);
        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-points', compact('data_provider', 'model', 'customers'));
    }

    public function actionManageDisinfectants() {

        $disinfectants = Disinfectant::getDisinfectants();
        $data_provider = Tools::wrapIntoDataProvider($disinfectants);
        return $this->render('disinfectants', compact('data_provider'));
    }

    public function actionManageDisinfectantsOnCustomers() {
        $users = Customer::getCustomersForManageDisinfectants();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('manage-disinfectants-on-customers', compact('data_provider'));
    }

    public function actionManageCustomerDisinfectant() {

        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new ManageDisinfectantsForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->updateDisinfectants($id);
        }

        $model->fetchDisinfectants($id);

        return $this->render('manage-customer-disinfectant', compact('model'));
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
                'rules' => [
                    [
                        'actions'=> ['users','upload-files','recommendations','delete-recommendation',
                            'scheme-point-control', 'edit-schema-point-control' ,'customers', 'add-customer',
                            'delete-customer', 'edit-customer', 'manage-points', 'manage-disinfectants',
                            'manage-disinfectants-on-customers', 'manage-customer-disinfectant'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'=> ['get-points-on-schema-point-control','save-point'],
                        'roles'     => [],
                        'allow'     => true
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'save-point'    =>  ['post']
                ],
            ],

        ];
    }

}