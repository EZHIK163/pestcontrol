<?php
namespace app\controllers;

use app\models\widget\Widget;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionScheme() {
        return $this->render('scheme');
    }

    public function actionInfoOnMonitoring() {
        return $this->render('info_on_monitoring');
    }

    public function actionReportOnPoint() {
        $labels = ["Приманка не тронута", "Частичная замена приманки", "Полная замена приманки", "Пойман вредитель"];
        $data_all_periods = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "My First dataset",
                    'backgroundColor' => "rgba(179,181,198,0.2)",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => [65, 59, 90, 81, 56, 55, 40]
                ]
            ]
        ];
        $data_current_month = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "My First dataset",
                    'backgroundColor' => "rgba(179,181,198,0.2)",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => [65, 59, 90, 81, 56, 55, 40]
                ]
            ]
        ];
        return $this->render('report_on_point', compact('data_current_month', 'data_all_periods'));
    }

    public function actionReportOnMaterial() {
        return $this->render('report_on_material');
    }

    public function actionRiskAssessment() {
        return $this->render('risk_assessment');
    }

    public function actionOccupancySchedule() {
        $current_year = [];
        $previous_year = [];
        $previous_previous_year = [];
        return $this->render('occupancy_schedule', compact('current_year', 'previous_previous_year', 'previous_year'));
    }

    public function actionRecommendations() {
        return $this->render('recommendations');
    }

    public function actionGeneralReport() {
        return $this->render('general_report');
    }

    public function actionCallEmployee() {
        return $this->render('call_employee');
    }

    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
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