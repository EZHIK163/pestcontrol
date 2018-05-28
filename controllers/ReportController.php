<?php
namespace app\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\filters\AccessControl;
use yii\web\Controller;


class ReportController extends Controller {

    public function actionReportDisinfectant() {

//        $spreadsheet = new Spreadsheet();
//        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->setCellValue('A1', 'Hello World !');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(\Yii::$app->basePath.'/templates/report-disinfectant.xlsx');

        $writer = new Xlsx($spreadsheet);
        $writer->save(\Yii::$app->basePath.'/web/reports/hello world.xlsx');
        //return $this->render('scheme', compact('data_provider', 'model'));
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['report-disinfectant'],
                'rules' => [
                    [
                        'actions'   => ['report-disinfectant'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}