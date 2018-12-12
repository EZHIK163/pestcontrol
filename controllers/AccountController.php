<?php
namespace app\controllers;

use app\models\customer\CalendarForm;
use app\models\customer\SearchForm;
use app\models\tools\Tools;
use app\models\widget\Widget;
use app\services\CustomerService;
use app\services\EventService;
use app\services\FileCustomerService;
use app\services\ReportService;
use DateTime;
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

    private $reportService;
    private $eventService;
    private $fileCustomerService;
    private $searchForm;

    /**
     * AccountController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param ReportService $reportService
     * @param EventService $eventService
     * @param FileCustomerService $fileCustomerService
     * @param SearchForm $searchForm
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
        SearchForm $searchForm,
        array $config = []
    ) {
        $this->reportService = $reportService;
        $this->customerService = $customerService;
        $this->eventService = $eventService;
        $this->fileCustomerService = $fileCustomerService;
        $this->searchForm = $searchForm;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|void
     */
    public function actionScheme()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);

        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = $this->searchForm;

        if (Yii::$app->request->isPost) {
            $model->query = Yii::$app->request->post('SearchForm')['query'];
        }

        $scheme_point_control = $model->getResultsForAccount($customer->getId());

        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme', compact('data_provider', 'model'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionShowSchemePointControl()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model_calendar = new CalendarForm();

        if ($model_calendar->load(Yii::$app->request->post()) && $model_calendar->validate()) {
            $from_datetime = $model_calendar->date_from;
            $to_datetime = $model_calendar->date_to;
            $_SESSION['from_datetime'] = $from_datetime;
            $_SESSION['to_datetime'] = $to_datetime;
        } elseif (Yii::$app->request->isGet
            && isset($_SESSION['from_datetime'])
            && isset($_SESSION['to_datetime'])) {
            $model_calendar->date_from = $from_datetime = $_SESSION['from_datetime'];
            $model_calendar->date_to = $to_datetime = $_SESSION['to_datetime'];
        } else {
            $model_calendar->date_from = $from_datetime = (new DateTime())->format('01.m.Y');
            $model_calendar->date_to = $to_datetime = (new DateTime())->format('d.m.Y');
        }

        $id_scheme = (int)Yii::$app->request->get('id');

        $model = $this->fileCustomerService->getSchemeForStat($id_scheme);

        return $this->render('show_scheme_point_control', compact('model', 'model_calendar'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionInfoOnMonitoring()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->date_from;
            $toDate = $model->date_to;
            $_SESSION['from_datetime'] = $fromDate;
            $_SESSION['to_datetime'] = $toDate;
        } elseif (Yii::$app->request->isGet
            && isset($_SESSION['from_datetime'])
            && isset($_SESSION['to_datetime'])) {
            $model->date_from = $fromDate = $_SESSION['from_datetime'];
            $model->date_to = $toDate = $_SESSION['to_datetime'];
        } else {
            $model->date_from = $fromDate = (new DateTime())->format('01.m.Y');
            $model->date_to = $toDate = (new DateTime())->format('d.m.Y');
        }

        $events = $this->eventService->getEventsStartFromTime($fromDate, $toDate, $customer->getId());

        $dataProvider = Tools::wrapIntoDataProvider($events, false, ['full_name', 'n_point', 'status', 'date_check']);

        return $this->render('info_on_monitoring', compact('model', 'dataProvider'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionReportOnPoint()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);

        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->date_from;
            $toDate = $model->date_to;
        } else {
            $model->date_from = $fromDate = (new DateTime())->format('01.m.Y');
            $model->date_to = $toDate = (new DateTime())->format('d.m.Y');
        }

        $data = $this->eventService->getPointReportFromPeriod($customer->getId(), $fromDate, $toDate);

        return $this->render('report_on_point', compact('data', 'model'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionReportOnMaterial()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
        } else {
            $model->date_from = $from_datetime = (new DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new DateTime())->format('d.m.Y');
        }

        $reportData = $this->reportService->getDataFromPeriod($from_datetime, $to_datetime, $customer->getId());

        $setting_column = $reportData['setting_column'];

        unset($reportData['setting_column']);

        $data_provider = Tools::wrapIntoDataProvider($reportData, false);

        return $this->render('report_on_material', compact('data_provider', 'model', 'setting_column'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionRiskAssessment()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dateFrom = $model->date_from;
            $dateTo = $model->date_to;
        } else {
            $model->date_from = $dateFrom = (new DateTime())->format('01.m.Y');
            $model->date_to = $dateTo = (new DateTime())->format('d.m.Y');
        }

        $greenRisk = $this->eventService->getGreenRisk($customer->getId(), $dateFrom, $dateTo);

        $dataProviderGreen = Tools::wrapIntoDataProvider($greenRisk, false);

        $redRisk = $this->eventService->getRedRisk($customer->getId(), $dateFrom, $dateTo);

        $dataProviderRed = Tools::wrapIntoDataProvider($redRisk, false);

        return $this->render('risk_assessment', compact('dataProviderGreen', 'dataProviderRed', 'model'));
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionOccupancySchedule()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fromDate = $model->date_from;
            $toDate = $model->date_to;
        } else {
            $model->date_from = $fromDate = (new DateTime())->format('01.m.Y');
            $model->date_to = $toDate = (new DateTime())->format('d.m.Y');
        }

        $data = $this->eventService->getOccupancyScheduleFromPeriod($customer->getId(), $fromDate, $toDate);

        return $this->render('occupancy_schedule', compact('data', 'model'));
    }

    /**
     * @return string
     */
    public function actionRecommendations()
    {
        $recommendations = $this->fileCustomerService->getRecommendationsForAccount();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    /**
     * @return string|void
     */
    public function actionGeneralReport()
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);

        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $currentMonth = $this->eventService->getGeneralReportCurrentMonth($customer->getId());

        return $this->render('general_report', compact('currentMonth'));
    }

    /**
     * @return string
     */
    public function actionCallEmployee()
    {
        return $this->render('call_employee');
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $id = Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);

        if ($customer) {
            $name_customer = $customer->getName();
        } else {
            $name_customer = '';
        }
        $params = array_merge($params, compact('name_customer'));
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
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
                            'report-on-point', 'info-on-monitoring', 'scheme', 'show-scheme-point-control'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}
