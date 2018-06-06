<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\CustomerForm;
use app\models\customer\Disinfectant;
use app\models\customer\Events;
use app\models\customer\FileCustomer;
use app\models\customer\FileCustomerType;
use app\models\customer\ManageDisinfectantForm;
use app\models\customer\ManageDisinfectantsForm;
use app\models\customer\ManageEventForm;
use app\models\customer\ManageEventsForm;
use app\models\customer\ManagePointForm;
use app\models\customer\ManagePointsForm;
use app\models\customer\Points;
use app\models\customer\PointStatus;
use app\models\customer\SearchForm;
use app\models\file\Files;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\user\UserRecord;
use app\models\widget\Widget;
use InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

class ManagerController extends Controller {

    public function beforeAction($action)
    {
        if (in_array($action->id , ['save-point', 'new-point'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionNewPoint($version = null) {

        $code_company = \Yii::$app->request->post('company');
        $id_disinfector = \Yii::$app->request->post('executor');
        $id_external = \Yii::$app->request->post('pointNum');
        $id_point_status = \Yii::$app->request->post('pointProp');

        $id_point_status++;

        \Yii::$app->response->format = Response::FORMAT_JSON;

        Events::addEvent($code_company, $id_disinfector, $id_external, $id_point_status);

        $my_data = [
            'success'   => 1,
            'message'   => 'Product successfully created'
        ];
        return $my_data;
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
        $is_show_free_points = \Yii::$app->request->get('is_show_free_points');

        $is_show_free_points = $is_show_free_points === 'true' ? true : false;

        if (!isset($id_file) or $id_file === 0) {
            throw new InvalidArgumentException();
        }

        $my_data = FileCustomer::getSchemeForEdit($id_file, $is_show_free_points);
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

    public function actionManagePoint() {

        $id_point = \Yii::$app->request->get('id');
        if (!isset($id_point)) {
            throw new InvalidArgumentException();
        }

        $model = new ManagePointForm($id_point);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->savePoint();
        }

        $id_customer = Points::getIdCustomerPoint($id_point);

        $scheme_point_control = FileCustomer::getSchemePointControlForDropDownList($id_customer);

        return $this->render('manage-point', compact('scheme_point_control', 'model'));
    }

    public function actionDeletePoint() {
        $id = \Yii::$app->request->get('id');
        if (isset($id)) {
            Points::deletePoint($id);
            $this->redirect('manage-points');
        }
    }

    public function actionEditDisinfectant() {
        $id = \Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new ManageDisinfectantForm($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->saveDisinfectant();
        }

        return $this->render('manage-disinfectant', compact( 'model'));
    }

    public function actionDeleteDisinfectant() {
        $id = \Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        Disinfectant::deleteDisinfectant($id);

        $this->redirect('manage-disinfectants');
    }

    public function actionAddDisinfectant() {

        $id = null;

        $model = new ManageDisinfectantForm($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->addDisinfectant();

            $this->redirect('manage-disinfectants');
        }

        return $this->render('add-disinfectant', compact( 'model'));
    }

    public function actionManageEvents() {

        $model = new ManageEventsForm();

        $id_customer = null;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $id_customer = $model->id_customer;
        }

        $customers = Customer::getCustomerForDropDownList();

        $points = Events::getEventsForManager($id_customer);

        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-events', compact('data_provider', 'model', 'customers'));
    }

    public function actionDeleteEvent() {
        $id = \Yii::$app->request->get('id');
        if (isset($id)) {
            Events::deleteEvent($id);
            $this->redirect('manage-events');
        }
    }

    public function actionEditEvent() {

        $id = \Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new ManageEventForm($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->saveEvent();
        }

        $point_status = PointStatus::getPointStatusesForDropDownList();

        return $this->render('manage-event', compact( 'model', 'point_status'));
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
                            'manage-disinfectants-on-customers', 'manage-customer-disinfectant', 'manage-point',
                            'delete-point', 'edit-disinfectant', 'delete-disinfectant', 'add-disinfectant',
                            'manage-events', 'delete-event', 'edit-event'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'=> ['get-points-on-schema-point-control','save-point', 'new-point'],
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