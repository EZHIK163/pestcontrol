<?php
namespace app\controllers;

use app\entities\DisinfectantRecord;
use app\entities\Events;
use app\entities\FileCustomer;
use app\models\customer\CalendarForm;
use app\models\customer\SearchForm;
use app\models\tools\Tools;
use app\models\widget\Widget;
use app\services\CustomerService;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountController extends Controller
{
    private $customerService;

    /**
     * AccountController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param array $config
     */
    public function __construct($id, Module $module, CustomerService $customerService, array $config = [])
    {
        $this->customerService = $customerService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionScheme() {
        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new SearchForm();

        if (\Yii::$app->request->isPost) {
            $model->query = \Yii::$app->request->post('SearchForm')['query'];
        }

        $scheme_point_control = $model->getResultsForAccount($customer->getId());

        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme', compact('data_provider', 'model'));
    }

    public function actionShowSchemePointControl() {

        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model_calendar = new CalendarForm();

        if ($model_calendar->load(\Yii::$app->request->post()) && $model_calendar->validate()) {
            $from_datetime = $model_calendar->date_from;
            $to_datetime = $model_calendar->date_to;
            $_SESSION['from_datetime'] = $from_datetime;
            $_SESSION['to_datetime'] = $to_datetime;
        } else if (\Yii::$app->request->isGet
            && isset($_SESSION['from_datetime'])
            && isset($_SESSION['to_datetime'])) {
            $model_calendar->date_from = $from_datetime = $_SESSION['from_datetime'];
            $model_calendar->date_to = $to_datetime = $_SESSION['to_datetime'];
        } else {
            $model_calendar->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model_calendar->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $id_scheme = (int)\Yii::$app->request->get('id');


        //$scheme_point_control = $model->getResultsForAccount($customer->id);

        //$data_provider = Tools::wrapIntoDataProvider($scheme_point_control);

        $model = FileCustomer::getSchemeForStat($id_scheme, $from_datetime, $to_datetime);

        return $this->render('show_scheme_point_control', compact('model', 'model_calendar'));
    }

    public function actionInfoOnMonitoring() {

        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
            $_SESSION['from_datetime'] = $from_datetime;
            $_SESSION['to_datetime'] = $to_datetime;
        } else if (\Yii::$app->request->isGet
            && isset($_SESSION['from_datetime'])
            && isset($_SESSION['to_datetime'])) {
            $model->date_from = $from_datetime = $_SESSION['from_datetime'];
            $model->date_to = $to_datetime = $_SESSION['to_datetime'];
        } else {
            $model->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $events = Events::getEventsFromPeriod($customer->getId(), $from_datetime, $to_datetime);

        $data_provider = Tools::wrapIntoDataProvider($events, false, ['full_name', 'n_point', 'status', 'date_check']);

        return $this->render('info_on_monitoring', compact('model', 'data_provider'));
    }

    public function actionReportOnPoint() {
        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);

        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
        } else {
            $model->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $data = Events::getPointReportFromPeriod($customer->getId(), $from_datetime, $to_datetime);

        return $this->render('report_on_point', compact('data', 'model'));
    }

    public function actionReportOnMaterial() {
        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
        } else {
            $model->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $disinfectant = DisinfectantRecord::getFromPeriod($customer->getId(), $from_datetime, $to_datetime);

        $setting_column = $disinfectant['setting_column'];

        unset($disinfectant['setting_column']);

        $data_provider = Tools::wrapIntoDataProvider($disinfectant, false);

        return $this->render('report_on_material', compact('data_provider', 'model', 'setting_column'));
    }

    public function actionRiskAssessment() {
        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
        } else {
            $model->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $green_risk = Events::getGreenRisk($customer->getId(), $from_datetime, $to_datetime);

        $data_provider_green = Tools::wrapIntoDataProvider($green_risk, false);

        $red_risk = Events::getRedRisk($customer->getId(), $from_datetime, $to_datetime);

        $data_provider_red = Tools::wrapIntoDataProvider($red_risk, false);

        return $this->render('risk_assessment', compact('data_provider_green', 'data_provider_red', 'model'));
    }

    public function actionOccupancySchedule() {

        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new CalendarForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $from_datetime = $model->date_from;
            $to_datetime = $model->date_to;
        } else {
            $model->date_from = $from_datetime = (new \DateTime())->format('01.m.Y');
            $model->date_to = $to_datetime = (new \DateTime())->format('d.m.Y');
        }

        $data = Events::getOccupancyScheduleFromPeriod($customer->getId(), $from_datetime, $to_datetime);
        //$previous_year = Events::getOccupancySchedulePreviousYear($customer->id);
        //$previous_previous_year = Events::getOccupancySchedulePreviousPreviousYear($customer->id);
        return $this->render('occupancy_schedule', compact('data', 'model'));
    }

    public function actionRecommendations() {
        $recommendations = FileCustomer::getRecommendationsForAccount();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    public function actionGeneralReport() {

        $id = \Yii::$app->user->id;
        $customer = $this->customerService->getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $data_current_month = Events::getGeneralReportCurrentMonth($customer->getId());

        return $this->render('general_report', compact('data_current_month'));
    }

    public function actionCallEmployee() {
        return $this->render('call_employee');
    }

    public function render($view, $params = [])
    {
        $id = \Yii::$app->user->id;
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

    public function actionGenerateReportSchemaPointControl() {
        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        //TODO Реализовать генерацию отчета по выбранной схеме точек контроля
    }

    public function actionPrintSchemaPointControl() {
        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        //TODO Реализовать печать по выбранной схеме точек контроля
    }

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