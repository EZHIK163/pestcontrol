<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\Disinfectant;
use app\models\customer\Events;
use app\models\customer\FileCustomer;
use app\models\customer\CalendarForm;
use app\models\customer\SearchForm;
use app\models\tools\Tools;
use app\models\widget\Widget;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AccountController extends Controller {


    public function actionIndex() {
        return $this->render('index');
    }

    public function actionScheme() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new SearchForm();

        if (\Yii::$app->request->isPost) {
            $model->query = \Yii::$app->request->post('SearchForm')['query'];
        }

        $scheme_point_control = $model->getResultsForAccount($customer->id);

        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme', compact('data_provider', 'model'));
    }

    public function actionInfoOnMonitoring() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
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

        $events = Events::getEventsFromPeriod($customer->id, $from_datetime, $to_datetime);

        $data_provider = Tools::wrapIntoDataProvider($events, false, ['full_name', 'n_point', 'status', 'date_check']);

        return $this->render('info_on_monitoring', compact('model', 'data_provider'));
    }

    public function actionReportOnPoint() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

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

        $data = Events::getPointReportFromPeriod($customer->id, $from_datetime, $to_datetime);

        return $this->render('report_on_point', compact('data', 'model'));
    }

    public function actionReportOnMaterial() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
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

        $disinfectant = Disinfectant::getFromPeriod($customer->id, $from_datetime, $to_datetime);

        $setting_column = $disinfectant['setting_column'];

        unset($disinfectant['setting_column']);

        $data_provider = Tools::wrapIntoDataProvider($disinfectant, false);

        return $this->render('report_on_material', compact('data_provider', 'model', 'setting_column'));
    }

    public function actionRiskAssessment() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
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

        $green_risk = Events::getGreenRisk($customer->id, $from_datetime, $to_datetime);

        $data_provider_green = Tools::wrapIntoDataProvider($green_risk, false);

        $red_risk = Events::getRedRisk($customer->id, $from_datetime, $to_datetime);

        $data_provider_red = Tools::wrapIntoDataProvider($red_risk, false);

        return $this->render('risk_assessment', compact('data_provider_green', 'data_provider_red', 'model'));
    }

    public function actionOccupancySchedule() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
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

        $data = Events::getOccupancyScheduleFromPeriod($customer->id, $from_datetime, $to_datetime);
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
        $customer = Customer::getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $data_current_month = Events::getGeneralReportCurrentMonth($customer->id);

        return $this->render('general_report', compact('data_current_month'));
    }

    public function actionCallEmployee() {
        return $this->render('call_employee');
    }

    public function render($view, $params = [])
    {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        if ($customer) {
            $name_customer = $customer->name;
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
                            'report-on-point', 'info-on-monitoring', 'scheme'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}