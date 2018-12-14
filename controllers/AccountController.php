<?php
namespace app\controllers;

use app\dto\Customer;
use app\exceptions\CustomerNotFound;
use app\forms\CalendarForm;
use app\forms\CallEmployeeForm;
use app\forms\SearchSchemeForm;
use app\services\CallEmployeeService;
use app\tools\Tools;
use app\components\Widget;
use app\services\CustomerService;
use app\services\EventService;
use app\services\FileCustomerService;
use app\services\ReportService;
use DateTime;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AccountController
 * @package app\controllers
 */
class AccountController extends Controller
{
    private $customerService;
    /**
     * @var Customer
     */
    private $customer;

    private $reportService;
    /**
     * @var EventService
     */
    private $eventService;
    /**
     * @var FileCustomerService
     */
    private $fileCustomerService;
    /**
     * @var SearchSchemeForm
     */
    private $searchForm;
    /**
     * @var CallEmployeeService
     */
    private $callEmployeeService;

    /**
     * AccountController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param ReportService $reportService
     * @param EventService $eventService
     * @param FileCustomerService $fileCustomerService
     * @param SearchSchemeForm $searchForm
     * @param CallEmployeeService $callEmployeeService
     * @param array $config
     */
    public function __construct(
        $id,
        Module
        $module,
        CustomerService $customerService,
        ReportService $reportService,
        EventService $eventService,
        FileCustomerService $fileCustomerService,
        SearchSchemeForm $searchForm,
        CallEmployeeService $callEmployeeService,
        array $config = []
    ) {
        $this->reportService = $reportService;
        $this->customerService = $customerService;
        $this->eventService = $eventService;
        $this->fileCustomerService = $fileCustomerService;
        $this->searchForm = $searchForm;
        $this->callEmployeeService = $callEmployeeService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $id = Yii::$app->user->id;
        try {
            $this->customer = $this->customerService->getCustomerByIdUser($id);
        } catch (CustomerNotFound $e) {
            $this->customer = null;
        }

        /*if (is_null($this->customer)) {
            $this->redirect('index');
        }*/

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionScheme()
    {
        $model = new SearchSchemeForm();

        $model->load(Yii::$app->request->post());
        $model->validate();

        $schemePointControl = $this->fileCustomerService->getSchemePointControlCustomer($this->customer->getId(), $model->query);

        $dataProvider = Tools::wrapIntoDataProvider($schemePointControl);

        return $this->render(
            'scheme',
            [
                'data_provider' => $dataProvider,
                'model'         => $model
            ]
        );
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionShowSchemePointControl()
    {
        $id = (int)Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model_calendar = new CalendarForm();

        if (isset($_SESSION['from_datetime']) && isset($_SESSION['to_datetime'])) {
            $model_calendar->dateFrom = $from_datetime = $_SESSION['from_datetime'];
            $model_calendar->dateTo = $to_datetime = $_SESSION['to_datetime'];
        } else {
            $model_calendar->dateFrom = $from_datetime = (new DateTime())->format('01.m.Y');
            $model_calendar->dateTo = $to_datetime = (new DateTime())->format('d.m.Y');
        }

        if ($model_calendar->load(Yii::$app->request->post()) && $model_calendar->validate()) {
            $from_datetime = $model_calendar->dateFrom;
            $to_datetime = $model_calendar->dateTo;
            $_SESSION['from_datetime'] = $from_datetime;
            $_SESSION['to_datetime'] = $to_datetime;
        }

        $model = $this->fileCustomerService->getSchemeForStat($id);

        return $this->render('show_scheme_point_control', compact('model', 'model_calendar'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionInfoOnMonitoring()
    {
        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->dateFrom;
            $toDate = $model->dateTo;
            $_SESSION['from_datetime'] = $fromDate;
            $_SESSION['to_datetime'] = $toDate;
        }

        if (isset($_SESSION['from_datetime']) && isset($_SESSION['to_datetime'])) {
            $model->dateFrom = $fromDate = $_SESSION['from_datetime'];
            $model->dateTo = $toDate = $_SESSION['to_datetime'];
        } else {
            $model->dateFrom = $fromDate = (new DateTime())->format('01.m.Y');
            $model->dateTo = $toDate = (new DateTime())->format('d.m.Y');
        }

        $events = $this->eventService->getEventsStartFromTime($fromDate, $toDate, $this->customer->getId());

        $dataProvider = Tools::wrapIntoDataProvider($events, false, ['full_name', 'n_point', 'status', 'date_check']);

        return $this->render('info_on_monitoring', compact('model', 'dataProvider'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionReportOnPoint()
    {
        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->dateFrom;
            $toDate = $model->dateTo;
        } else {
            $model->dateFrom = $fromDate = (new DateTime())->format('01.m.Y');
            $model->dateTo = $toDate = (new DateTime())->format('d.m.Y');
        }

        $data = $this->eventService->getPointReportFromPeriod($this->customer->getId(), $fromDate, $toDate);

        return $this->render('report_on_point', compact('data', 'model'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionReportOnMaterial()
    {
        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->dateFrom;
            $to_datetime = $model->dateTo;
        } else {
            $model->dateFrom = $from_datetime = (new DateTime())->format('01.m.Y');
            $model->dateTo = $to_datetime = (new DateTime())->format('d.m.Y');
        }

        $reportData = $this->reportService->getDataFromPeriod($from_datetime, $to_datetime, $this->customer->getId());

        $settingColumn = $reportData['setting_column'];

        unset($reportData['setting_column']);

        $dataProvider = Tools::wrapIntoDataProvider($reportData, false);

        return $this->render(
            'report_on_material',
            [
                'data_provider'     => $dataProvider,
                'model'             => $model,
                'setting_column'    => $settingColumn
            ]
        );
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionRiskAssessment()
    {
        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dateFrom = $model->dateFrom;
            $dateTo = $model->dateTo;
        } else {
            $model->dateFrom = $dateFrom = (new DateTime())->format('01.m.Y');
            $model->dateTo = $dateTo = (new DateTime())->format('d.m.Y');
        }

        $greenRisk = $this->eventService->getGreenRisk($this->customer->getId(), $dateFrom, $dateTo);

        $dataProviderGreen = Tools::wrapIntoDataProvider($greenRisk, false);

        $redRisk = $this->eventService->getRedRisk($this->customer->getId(), $dateFrom, $dateTo);

        $dataProviderRed = Tools::wrapIntoDataProvider($redRisk, false);

        return $this->render(
            'risk_assessment',
            [
                'data_provider_green' => $dataProviderGreen,
                'data_provider_red'   => $dataProviderRed,
                'model'               => $model
            ]
        );
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionOccupancySchedule()
    {
        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->dateFrom;
            $toDate = $model->dateTo;
        } else {
            $model->dateFrom = $fromDate = (new DateTime())->format('01.m.Y');
            $model->dateTo = $toDate = (new DateTime())->format('d.m.Y');
        }

        $data = $this->eventService->getOccupancyScheduleFromPeriod($this->customer->getId(), $fromDate, $toDate);

        return $this->render('occupancy_schedule', compact('data', 'model'));
    }

    /**
     * @return string
     */
    public function actionRecommendations()
    {
        $recommendations = $this->fileCustomerService->getRecommendationsForAccount();

        $dataProvider = Tools::wrapIntoDataProvider($recommendations);

        return $this->render('recommendations', ['data_provider'    => $dataProvider]);
    }

    /**
     * @return string
     */
    public function actionGeneralReport()
    {
        $currentMonth = $this->eventService->getGeneralReportCurrentMonth($this->customer->getId());

        return $this->render('general_report', ['current_month'  => $currentMonth]);
    }

    /**
     * @return string
     */
    public function actionCallEmployee()
    {
        $model = new CallEmployeeForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->validateEmail()) {
            $this->callEmployeeService->call($model->fillCallEmployee(), $this->customer->getId());
            $this->redirect('call-employee-success');
        }

        return $this->render('call_employee', ['model'  => $model]);
    }

    /**
     * @return string
     */
    public function actionCallEmployeeSuccess()
    {
        return $this->render('call_employee_success');
    }

    /**
     *
     */
    public function actionGenerateReportSchemaPointControl()
    {
        $id = Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        //TODO Реализовать генерацию отчета по выбранной схеме точек контроля
    }

    /**
     *
     */
    public function actionPrintSchemaPointControl()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        //TODO Реализовать печать по выбранной схеме точек контроля
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $nameCustomer = $this->customer !== null ? $this->customer->getName() : '';

        $params = array_merge($params, ['name_customer' => $nameCustomer]);
        $params = array_merge($params, Widget::getWidgetsForAccount());

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
                        'actions'   => ['index', 'call-employee', 'general-report',
                            'recommendations', 'occupancy-schedule', 'risk-assessment', 'report-on-material',
                            'report-on-point', 'info-on-monitoring', 'scheme', 'show-scheme-point-control',
                            'call-employee-success', 'generate-report-schema-point-control'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}
