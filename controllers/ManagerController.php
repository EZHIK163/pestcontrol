<?php
namespace app\controllers;

use app\entities\Disinfector;
use app\entities\Events;
use app\entities\FileCustomer;
use app\models\customer\ManageEventForm;
use app\models\customer\ManageEventsForm;
use app\models\customer\ManagePointForm;
use app\models\customer\ManagePointsForm;
use app\entities\Points;
use app\entities\PointStatus;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\widget\Widget;
use app\services\CustomerService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerController extends Controller
{
    private $customerService;

    /**
     * {@inheritdoc}
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['save-point', 'new-point', 'new-event', 'get-statuses'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param null $version
     * @return array
     */
    public function actionNewPoint($version = null)
    {
        $code_company = Yii::$app->request->post('company');
        $id_disinfector = Yii::$app->request->post('executor');
        $id_external = Yii::$app->request->post('pointNum');
        $id_point_status = Yii::$app->request->post('pointProp');

        $id_point_status++;

        Yii::$app->response->format = Response::FORMAT_JSON;

        Events::addEvent($code_company, $id_disinfector, $id_external, $id_point_status);

        $my_data = [
            'success'   => 1,
            'message'   => 'Product successfully created'
        ];
        return $my_data;
    }

    /**
     * @return array
     */
    public function actionNewEvent()
    {
        $id_company = Yii::$app->request->post('id_company');
        $id_desinector = Yii::$app->request->post('id_desinector');
        $id_point = Yii::$app->request->post('id_point');
        $id_status = Yii::$app->request->post('id_status');
        $count = Yii::$app->request->post('count');

        Yii::$app->response->format = Response::FORMAT_JSON;

        Events::addEvent2($id_company, $id_desinector, $id_point, $id_status, $count);

        $my_data = [
            'status'   => true
        ];
        return $my_data;
    }

    /**
     * @return array
     */
    public function actionGetStatuses()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $statuses = PointStatus::getStatusesForApplication();

        $my_data = [
            'statuses'   => $statuses
        ];
        return $my_data;
    }

    /**
     * @return string
     */
    public function actionUsers()
    {
        return $this->render('userList', User::getUsersForAdmin());
    }

    /**
     * @return array
     */
    public function actionSavePoint()
    {
        $points = Yii::$app->request->post('points');
        $id_file_customer = (int)Yii::$app->request->post('id_file_customer');
        if (!isset($points) or $id_file_customer === 0) {
            throw new \yii\base\InvalidArgumentException();
        }

        FileCustomer::savePoints($id_file_customer, $points);

        $data = ['status'   => true];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

    /**
     * @return string
     */
    public function actionManagePoints()
    {
        $model = new ManagePointsForm();

        $id_customer = null;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id_customer = $model->id_customer;
        }

        $customers = $this->customerService->getCustomerForDropDownList();

        $points = Points::getPointsForManager($id_customer);
        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-points', compact('data_provider', 'model', 'customers'));
    }

    /**
     * @return string
     * @throws \yii\base\ErrorException
     */
    public function actionManagePoint()
    {
        $id_point = Yii::$app->request->get('id');
        if (!isset($id_point)) {
            throw new InvalidArgumentException();
        }

        $model = new ManagePointForm($id_point);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->savePoint();
        }

        $id_customer = Points::getIdCustomerPoint($id_point);

        $scheme_point_control = FileCustomer::getSchemePointControlForDropDownList($id_customer);

        return $this->render('manage-point', compact('scheme_point_control', 'model'));
    }

    /**
     *
     */
    public function actionDeletePoint()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            Points::deletePoint($id);
            $this->redirect('manage-points');
        }
    }

    /**
     * @return string
     */
    public function actionManageEvents()
    {
        $model = new ManageEventsForm();

        $id_customer = null;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id_customer = $model->id_customer;
        }

        $customers = $this->customerService->getCustomerForDropDownList();

        $points = Events::getEventsForManager($id_customer);

        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-events', compact('data_provider', 'model', 'customers'));
    }

    /**
     *
     */
    public function actionDeleteEvent()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            Events::deleteEvent($id);
            $this->redirect('manage-events');
        }
    }

    /**
     * @return string
     */
    public function actionEditEvent()
    {
        $id = Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new ManageEventForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveEvent();
        }

        $point_status = PointStatus::getPointStatusesForDropDownList();

        return $this->render('manage-event', compact( 'model', 'point_status'));
    }

    /**
     * @return string
     */
    public function actionManageDisinfectors()
    {
        $disinfectors = Disinfector::getAllForManager();

        $data_provider = Tools::wrapIntoDataProvider($disinfectors);
        return $this->render('manage-disinfectors', compact('data_provider'));
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
                'rules' => [
                    [
                        'actions'=> ['users', 'manage-points',  'manage-point',
                            'delete-point', 'manage-events', 'delete-event', 'edit-event', 'manage-disinfectors'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'=> ['get-points-on-schema-point-control','save-point', 'new-point',
                            'new-event', 'get-statuses'],
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