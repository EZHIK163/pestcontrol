<?php
namespace app\controllers;

use app\entities\DisinfectorRecord;
use app\entities\EventRecord;
use app\entities\FileCustomerRecord;
use app\models\customer\ManageEventForm;
use app\models\customer\ManageEventsForm;
use app\models\customer\ManagePointForm;
use app\models\customer\ManagePointsForm;
use app\entities\PointRecord;
use app\entities\PointStatusRecord;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\widget\Widget;
use app\services\CustomerService;
use app\services\DisinfectorService;
use app\services\EventService;
use app\services\FileCustomerService;
use app\services\PointService;
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
    private $disinfectorService;
    private $eventService;
    private $manageEventForm;
    private $pointService;
    private $fileCustomerService;

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
     * @param DisinfectorService $disinfectorService
     * @param EventService $eventService
     * @param ManageEventForm $manageEventForm
     * @param PointService $pointService
     * @param FileCustomerService $fileCustomerService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        DisinfectorService $disinfectorService,
        EventService $eventService,
        ManageEventForm $manageEventForm,
        PointService $pointService,
        FileCustomerService $fileCustomerService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->disinfectorService = $disinfectorService;
        $this->eventService = $eventService;
        $this->manageEventForm = $manageEventForm;
        $this->pointService = $pointService;
        $this->fileCustomerService = $fileCustomerService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param null $version
     * @return array
     */
    public function actionNewPoint()
    {
        $codeCompany = Yii::$app->request->post('company');
        $idDisinfector = Yii::$app->request->post('executor');
        $idInternal = Yii::$app->request->post('pointNum');
        $idPointStatus = Yii::$app->request->post('pointProp');

        $idPointStatus++;

        Yii::$app->response->format = Response::FORMAT_JSON;

        $this->eventService->addEventFromOldAndroidApplication($codeCompany, $idDisinfector, $idInternal, $idPointStatus);

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

        $this->eventService->addEventFromNewAndroidApplication($id_company, $id_desinector, $id_point, $id_status, $count);

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

        $statuses = $this->pointService->getStatusesForApplication();

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

        $this->pointService->savePoints($id_file_customer, $points);

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

        $points = $this->pointService->getPointsForManager($id_customer);
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

        $model = new ManagePointForm();
        $point = $this->pointService->getItemForEditing($id_point);
        $model->fillThis($point);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->pointService->saveItem(
                $model->id_point,
                $model->x_coordinate,
                $model->y_coordinate,
                $model->title,
                $model->id_scheme_point_control
            );
        }

        $idCustomer = $this->pointService->getIdCustomerPoint($id_point);

        $scheme_point_control = $this->fileCustomerService->getSchemePointControlForDropDownList($idCustomer);

        return $this->render('manage-point', compact('scheme_point_control', 'model'));
    }

    /**
     *
     */
    public function actionDeletePoint()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $this->pointService->deletePoint($id);
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

        $points = $this->eventService->getEventsForManager($id_customer);

        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-events', compact('data_provider', 'model', 'customers'));
    }

    /**
     *
     */
    public function actionDeleteEvent()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }
        $this->eventService->deleteEvent($id);
        $this->redirect('manage-events');
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

        $model = $this->manageEventForm;

        $event = $this->eventService->getItemForEditing($id);
        $model->fillThis($event);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->eventService->saveItem($model->id_event, $model->id_point_status);
        }

        $point_status = $this->pointService->getPointStatusesForDropDownList();

        return $this->render('manage-event', compact('model', 'point_status'));
    }

    /**
     * @return string
     */
    public function actionManageDisinfectors()
    {
        $disinfectors = $this->disinfectorService->getAllForManager();
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
                        'actions'=> ['save-point', 'new-point',
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
