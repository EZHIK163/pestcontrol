<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\Disinfectant;
use app\models\customer\Events;
use app\models\customer\FileCustomer;
use app\models\customer\OccupancyForm;
use app\models\customer\SearchForm;
use app\models\tools\Tools;
use app\models\widget\Widget;
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

        $events = Events::getEventsCurrentMonth($customer->id);

        $data_provider_start_month = Tools::wrapIntoDataProvider($events, false);

        $events = Events::getEventsCurrentYear($customer->id);
        $data_provider_start_year = Tools::wrapIntoDataProvider($events, false);
        return $this->render('info_on_monitoring', compact('data_provider_start_month', 'data_provider_start_year'));
    }

    public function actionReportOnPoint() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

//        $labels = ["Приманка не тронута", "Частичная замена приманки", "Полная замена приманки", "Пойман вредитель"];
//        $data_all_periods = [
//            'labels' => $labels,
//            'datasets' => [
//                [
//                    'label' => "My First dataset",
//                    'data' => [65, 59, 90, 81, 56, 55, 40]
//                ]
//            ]
//        ];
//        $data_current_month = [
//            'labels' => $labels,
//            'datasets' => [
//                [
//                    'label' => "My First dataset",
//                    'data' => [65, 59, 90, 81, 56, 55, 40]
//                ]
//            ]
//        ];


        $data_current_month = Events::getPointReportCurrentMonth($customer->id);

        $data_all_periods = Events::getPointReportAllPeriod($customer->id);

        return $this->render('report_on_point', compact('data_current_month', 'data_all_periods'));
    }

    public function actionReportOnMaterial() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $disinfectant_current_month = Disinfectant::getCurrentMonth($customer->id);

        $data_provider_current_month = Tools::wrapIntoDataProvider($disinfectant_current_month, false);

        $disinfectant_previous_month = Disinfectant::getCurrentMonth($customer->id);

        $data_provider_previous_month = Tools::wrapIntoDataProvider($disinfectant_previous_month, false);

        return $this->render('report_on_material', compact('data_provider_current_month', 'data_provider_previous_month'));
    }

    public function actionRiskAssessment() {
        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);
        if (is_null($customer)) {
            $this->redirect('index');
            return;
        }

        $model = new OccupancyForm();

        $from_datetime = $to_datetime = null;
        if (\Yii::$app->request->isPost) {
            $from_datetime = $model->date_from = \Yii::$app->request->post('OccupancyForm')['date_from'];
            $to_datetime = $model->date_to = \Yii::$app->request->post('OccupancyForm')['date_to'];
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

        $current_year = Events::getOccupancyScheduleCurrentYear($customer->id);
        $previous_year = Events::getOccupancySchedulePreviousYear($customer->id);
        $previous_previous_year = Events::getOccupancySchedulePreviousPreviousYear($customer->id);
        return $this->render('occupancy_schedule', compact('current_year', 'previous_previous_year', 'previous_year'));
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
                'only'  => ['index', 'call-employee', 'general_report',
                    'recommendations', 'occupancy_schedule', 'risk_assessment', 'report_on_material',
                    'report_on_point', 'info_on_monitoring', 'scheme'],
                'rules' => [
                    [
                        'actions'   => ['index', 'call-employee', 'general_report',
                            'recommendations', 'occupancy_schedule', 'risk_assessment', 'report_on_material',
                            'report_on_point', 'info_on_monitoring', 'scheme'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}