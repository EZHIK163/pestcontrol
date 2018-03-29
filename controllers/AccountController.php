<?php
namespace app\controllers;

use app\models\customer\FileCustomer;
use app\models\tools\Tools;
use app\models\widget\Widget;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AccountController extends Controller {

    public function beforeAction($action)
    {
        if ($action->id == 'save-point') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionScheme() {
        $id_scheme_point_control = 666;
        return $this->render('scheme', compact('id_scheme_point_control'));
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
        $recommendations = FileCustomer::getRecommendationsForAccount();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    public function actionGeneralReport() {
        return $this->render('general_report');
    }

    public function actionCallEmployee() {
        return $this->render('call_employee');
    }

    public function actionGetPointsOnSchemaPointControl() {
        $id = \Yii::$app->request->get('id_scheme_point_control');
        $data[666] = [
            'img'       => 'http://koffkindom.ru/wp-content/uploads/2016/02/plan-doma-8x8-2et-10.jpg',
            'points'    => [
                [
                    'id'        => 'point_1',
                    'x'         => 0,
                    'y'         => 0,
                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
                ],
                [
                    'id'        => 'point_2',
                    'x'         => 10,
                    'y'         => 10,
                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
                ],
                [
                    'id'        => 'point_3',
                    'x'         => 312,
                    'y'         => 104,
                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
                ]
            ]
        ];
        $my_data = $data[$id];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $my_data;
    }

    public function actionSavePoint() {
        $data = ['status'   => true];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
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