<?php
namespace app\controllers;

use app\components\MyReadFilter;
use app\models\customer\Customer;
use app\models\customer\Disinfectant;
use app\models\customer\Events;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use yii\filters\AccessControl;
use yii\web\Controller;


class ReportController extends Controller {

    public function actionReportDisinfectantToExcel() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        $from_datetime = \Yii::$app->request->get('from_datetime');
        $to_datetime = \Yii::$app->request->get('to_datetime');

        //$from_datetime = (new \DateTime($from_datetime))->format('01.01.Y');
        //$to_datetime = (new \DateTime($to_datetime))->format('d.m.Y');;

        $data = Disinfectant::getDataForReport($customer->id, $from_datetime, $to_datetime) ;

        $filterSubset = new MyReadFilter();

        $inputFileType = 'Xlsx';
        $inputFileName = \Yii::$app->basePath.'/templates/report-disinfectant.xlsx';

        $reader = IOFactory::createReader($inputFileType);

        $reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($inputFileName);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('B2', $from_datetime);
        $sheet->setCellValue('C2', '-');
        $sheet->setCellValue('D2', $to_datetime);

        $sheet->setCellValue('I1', $customer->name);

        $index = 1;
        $row = 6;

        $start_cell = 'A'.$row;
        foreach ($data as $item) {
            $sheet
                ->setCellValue('A'.$row, $index);
            $sheet
                ->setCellValue('B'.$row, $item['name']);
            $sheet
                ->setCellValue('D'.$row, $item['form_of_facility']);
            $sheet
                ->setCellValue('E'.$row,
                    $item['active_substance'].', '.$item['concentration_of_substance']);
            $sheet
                ->setCellValue('F'.$row, $item['manufacturer']);
            $sheet
                ->setCellValue('G'.$row, $item['terms_of_use']);
            $sheet
                ->setCellValue('H'.$row, $item['place_of_application']);
            $sheet
                ->setCellValue('I'.$row, $item['value']);
            $sheet
                ->setCellValue('J'.$row, $item['disinfector']);

            $row++;
            $index++;
        }

        $end_cell = 'J'.($row - 1);

        $styleArray = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal'    => Alignment::HORIZONTAL_CENTER,
                'vertical'      =>  Alignment::VERTICAL_CENTER,
                'wrapText'      => true
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->setBreak('A10', Worksheet::BREAK_ROW);
        $spreadsheet->getActiveSheet()->setBreak('D10', Worksheet::BREAK_COLUMN);

        $current_style = $sheet->getStyle($start_cell.':'.$end_cell);
        $sheet->rangeToArray("A1:Z10", null, true, false, false);
        $current_style->applyFromArray($styleArray);


        $name_file = 'Отчет по дезсредствам.xlsx';

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(\Yii::$app->basePath.'/temp/temp.xlsx');

        return \Yii::$app->response->sendFile(
            \Yii::$app->basePath.'/temp/temp.xlsx',
            $name_file,
            ['mimeType'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function actionReportDisinfectantToWord() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        $from_datetime = \Yii::$app->request->get('from_datetime');
        $to_datetime = \Yii::$app->request->get('to_datetime');

        $data = Disinfectant::getDataForReport($customer->id, $from_datetime, $to_datetime) ;

        $phpWord = new PhpWord();

        $phpWord->getCompatibility()->setOoxmlVersion(14);
        $phpWord->getCompatibility()->setOoxmlVersion(15);

        $templateProcessor = new TemplateProcessor(\Yii::$app->basePath.'/templates/report-disinfectant.docx');
        //$targetFile = \Yii::$app->basePath;
       // $filename = 'test.docx';

        $templateProcessor->setValue('client_name', $customer->name);
        $templateProcessor->setValue('start_period', $from_datetime);
        $templateProcessor->setValue('end_period', $to_datetime);

        $templateProcessor->cloneRow('index', count($data));

        $index = 1;
        foreach ($data as $disinfectant) {

            if (empty($disinfectant['concentration_of_substance'])) {
                $active_substance_concentration_of_substance = $disinfectant['form_of_facility'];
            } else {
                $active_substance_concentration_of_substance = $disinfectant['form_of_facility'].', '.$disinfectant['concentration_of_substance'];
            }
            $templateProcessor->setValue('index#'.$index, $index);
            $templateProcessor->setValue('name#'.$index, $disinfectant['name']);
            $templateProcessor->setValue('form_of_facility#'.$index, $disinfectant['name']);
            $templateProcessor->setValue('active_substance_concentration_of_substance#'.$index, $active_substance_concentration_of_substance);
            $templateProcessor->setValue('manufacturer#'.$index, $disinfectant['manufacturer']);
            $templateProcessor->setValue('terms_of_use#'.$index, $disinfectant['terms_of_use']);
            $templateProcessor->setValue('place_of_application#'.$index, $disinfectant['place_of_application']);
            $templateProcessor->setValue('value#'.$index, $disinfectant['value']);

            $index++;
        }

        $name_file = 'Отчет по дезсредствам.docx';
        $templateProcessor->saveAs(\Yii::$app->basePath.'/temp/temp.docx');

        return \Yii::$app->response->sendFile(
            \Yii::$app->basePath.'/temp/temp.docx',
            $name_file,
            ['mimeType'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        );

    }

    public function actionReportPointsToWord() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        $data = Events::getDataForReport($customer->id) ;

        $phpWord = new PhpWord();

        $phpWord->getCompatibility()->setOoxmlVersion(14);
        $phpWord->getCompatibility()->setOoxmlVersion(15);

        $templateProcessor = new TemplateProcessor(\Yii::$app->basePath.'/templates/report-points.docx');

        $templateProcessor->setValue('client_name', $customer->name);

        $templateProcessor->cloneRow('n_', count($data));

        $index = 1;
        foreach ($data as $id_external => $points) {
            $january = isset($points['01']) ? $points['01'] : '';
            $february = isset($points['02']) ? $points['02'] : '';
            $march = isset($points['03']) ? $points['03'] : '';
            $april = isset($points['04']) ? $points['04'] : '';
            $may = isset($points['05']) ? $points['05'] : '';
            $june = isset($points['06']) ? $points['06'] : '';
            $july = isset($points['07']) ? $points['07'] : '';
            $august = isset($points['08']) ? $points['08'] : '';
            $september = isset($points['09']) ? $points['09'] : '';
            $october = isset($points['10']) ? $points['10'] : '';
            $november = isset($points['11']) ? $points['11'] : '';
            $december = isset($points['12']) ? $points['12'] : '';

            $templateProcessor->setValue('n_#'.$index, $points['name']);
            $templateProcessor->setValue('p#'.$index, $id_external);
            $templateProcessor->setValue('j#'.$index, $january);
            $templateProcessor->setValue('f#'.$index, $february);
            $templateProcessor->setValue('mc#'.$index, $march);
            $templateProcessor->setValue('a#'.$index, $april);
            $templateProcessor->setValue('m#'.$index, $may);
            $templateProcessor->setValue('jn#'.$index, $june);
            $templateProcessor->setValue('jl#'.$index, $july);
            $templateProcessor->setValue('a#'.$index, $august);
            $templateProcessor->setValue('s#'.$index, $september);
            $templateProcessor->setValue('o#'.$index, $october);
            $templateProcessor->setValue('n#'.$index, $november);
            $templateProcessor->setValue('d#'.$index, $december);

            $index++;
        }

        $name_file = 'Отчет по точкам.docx';
        $templateProcessor->saveAs(\Yii::$app->basePath.'/temp/temp.docx');

        return \Yii::$app->response->sendFile(
            \Yii::$app->basePath.'/temp/temp.docx',
            $name_file,
            ['mimeType'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        );

    }

    public function actionReportPointsToExcel() {

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        $data = Events::getDataForReport($customer->id) ;

        $inputFileType = 'Xlsx';
        $inputFileName = \Yii::$app->basePath.'/templates/report-points.xlsx';

        $reader = IOFactory::createReader($inputFileType);

        //$reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($inputFileName);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('B3', $customer->name);

        $spreadsheet->getActiveSheet()->insertNewRowBefore(7, count($data));

        $row = 7;

        $start_cell = 'A'.$row;
        foreach ($data as $id_external => $points) {

            $january = isset($points['01']) ? $points['01'] : '';
            $february = isset($points['02']) ? $points['02'] : '';
            $march = isset($points['03']) ? $points['03'] : '';
            $april = isset($points['04']) ? $points['04'] : '';
            $may = isset($points['05']) ? $points['05'] : '';
            $june = isset($points['06']) ? $points['06'] : '';
            $july = isset($points['07']) ? $points['07'] : '';
            $august = isset($points['08']) ? $points['08'] : '';
            $september = isset($points['09']) ? $points['09'] : '';
            $october = isset($points['10']) ? $points['10'] : '';
            $november = isset($points['11']) ? $points['11'] : '';
            $december = isset($points['12']) ? $points['12'] : '';

            $sheet->setCellValue('A'.$row, $points['name']);
            $sheet->setCellValue('B'.$row, $id_external);
            $sheet->setCellValue('C'.$row, $january);
            $sheet->setCellValue('D'.$row, $february);
            $sheet->setCellValue('E'.$row, $march);
            $sheet->setCellValue('F'.$row, $april);
            $sheet->setCellValue('G'.$row, $may);
            $sheet->setCellValue('H'.$row, $june);
            $sheet->setCellValue('I'.$row, $july);
            $sheet->setCellValue('J'.$row, $august);
            $sheet->setCellValue('K'.$row, $september);
            $sheet->setCellValue('L'.$row, $october);
            $sheet->setCellValue('M'.$row, $november);
            $sheet->setCellValue('N'.$row, $december);

            $row++;
        }

        $end_cell = 'N'.($row - 1);

        $styleArray = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal'    => Alignment::HORIZONTAL_CENTER,
                'vertical'      =>  Alignment::VERTICAL_CENTER,
                'wrapText'      => true
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $current_style = $sheet->getStyle($start_cell.':'.$end_cell);
        $current_style->applyFromArray($styleArray);


        $name_file = 'Отчет по точкам.xlsx';

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(\Yii::$app->basePath.'/temp/temp.xlsx');

        return \Yii::$app->response->sendFile(
            \Yii::$app->basePath.'/temp/temp.xlsx',
            $name_file,
            ['mimeType'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['report-disinfectant-to-excel', 'report-disinfectant-to-word',
                    'report-points-to-word', 'report-points-to-excel'],
                'rules' => [
                    [
                        'actions'   => ['report-disinfectant-to-excel', 'report-disinfectant-to-word',
                            'report-points-to-word', 'report-points-to-excel'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}