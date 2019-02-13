<?php
namespace app\controllers;

use app\forms\PointForm;
use app\forms\PointsForm;
use app\tools\Tools;
use app\components\MainWidget;
use app\services\CustomerService;
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
 * Class ManagerPointController
 * @package app\controllers
 */
class ManagerPointController extends Controller
{
    private $customerService;
    private $pointService;
    private $fileCustomerService;
    private $eventService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param PointService $pointService
     * @param FileCustomerService $fileCustomerService
     * @param EventService $eventService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        PointService $pointService,
        FileCustomerService $fileCustomerService,
        EventService $eventService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->pointService = $pointService;
        $this->fileCustomerService = $fileCustomerService;
        $this->eventService = $eventService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['save-point', 'new-point', 'get-statuses'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function actionNewPoint()
    {
        $codeCompany = Yii::$app->request->post('company');
        $idDisinfector = Yii::$app->request->post('executor');
        $idInternal = Yii::$app->request->post('pointNum');
        $idPointStatus = Yii::$app->request->post('pointProp');

        $idPointStatus++;

        $this->eventService->addEventFromOldAndroidApplication(
            $codeCompany,
            $idDisinfector,
            $idInternal,
            $idPointStatus
        );

        $myData = [
            'success'   => 1,
            'message'   => 'Product successfully created'
        ];

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $myData;
    }

    /**
     * @return array
     */
    public function actionGetStatuses()
    {
        $statuses = $this->pointService->getStatusesForApplication();

        $myData = [
            'statuses'   => $statuses
        ];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $myData;
    }

    /**
     * @return array
     */
    public function actionSavePoint()
    {
        $points = Yii::$app->request->post('points');
        $idFileCustomer = (int)Yii::$app->request->post('id_file_customer');

        if (!isset($points) or $idFileCustomer === 0 or empty($points)) {
            throw new \yii\base\InvalidArgumentException();
        }

        $this->pointService->savePoints($idFileCustomer, $points);

        $data = ['status'   => true];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    /**
     * @return string
     */
    public function actionManagePoints()
    {
        $model = new PointsForm();

        $model->load(Yii::$app->request->post());
        $model->validate();

        $customers = $this->customerService->getCustomerForDropDownList();

        $points = $this->pointService->getPointsForManager($model->idCustomer);
        $dataProvider = Tools::wrapIntoDataProvider($points);

        return $this->render(
            'manage-points',
            [
                'data_provider'     => $dataProvider,
                'model'             => $model,
                'customers'         => $customers
            ]
        );
    }

    /**
     * @return string
     */
    public function actionManagePoint()
    {
        $idPoint = Yii::$app->request->get('id');
        if (!isset($idPoint)) {
            throw new InvalidArgumentException();
        }

        $model = new PointForm();
        $point = $this->pointService->getItemForEditing($idPoint);
        $model->fillThis($point);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->pointService->saveItem(
                $model->idPoint,
                $model->xCoordinate,
                $model->yCoordinate,
                $model->title,
                $model->idSchemePointControl
            );
            $this->redirect('manage-points');
        }

        $idCustomer = $this->pointService->getIdCustomerPoint($idPoint);

        $schemePointControl = $this->fileCustomerService->getSchemePointControlForDropDownList($idCustomer);

        return $this->render('manage-point', ['scheme_point_control'    => $schemePointControl, 'model'   => $model]);
    }

    /**
     *
     */
    public function actionDisablePoint()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $this->pointService->disablePoint($id);
            $this->redirect('manage-points');
        }
    }

    public function actionEnablePoint()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $this->pointService->enablePoint($id);
            $this->redirect('manage-points');
        }
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $params = array_merge($params, MainWidget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
                'rules' => [
                    [
                        'actions'=> ['manage-points',  'manage-point', 'disable-point', 'enable-point'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'=> ['save-point', 'new-point', 'get-statuses'],
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
