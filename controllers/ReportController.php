<?php
namespace app\controllers;

use app\components\MyReadFilter;
use app\models\customer\Customer;
use app\models\customer\Disinfectant;
use Codeception\Lib\Di;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\filters\AccessControl;
use yii\web\Controller;


class ReportController extends Controller {

    public function actionReportDisinfectant() {

//        $spreadsheet = new Spreadsheet();
//        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->setCellValue('A1', 'Hello World !');

        $id = \Yii::$app->user->id;
        $customer = Customer::getCustomerByIdUser($id);

        $from_datetime = \Yii::$app->request->get('from_datetime');
        $to_datetime = \Yii::$app->request->get('to_datetime');

        //$from_datetime = (new \DateTime($from_datetime))->format('01.01.Y');
        //$to_datetime = (new \DateTime($to_datetime))->format('d.m.Y');;

        $data = Disinfectant::getDataForReport($customer->id, $from_datetime, $to_datetime) ;
        /**  Create an Instance of our Read Filter  **/

        $filterSubset = new MyReadFilter();

        $inputFileType = 'Xlsx';
        $inputFileName = \Yii::$app->basePath.'/templates/report-disinfectant.xlsx';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = IOFactory::createReader($inputFileType);
        /**  Tell the Reader that we want to use the Read Filter  **/
        $reader->setReadFilter($filterSubset);
        /**  Load only the rows and columns that match our filter to Spreadsheet  **/
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

        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        $spreadsheet->getActiveSheet()->setBreak('A10', Worksheet::BREAK_ROW);
        $spreadsheet->getActiveSheet()->setBreak('D10', Worksheet::BREAK_COLUMN);
        //$spreadsheet->getActiveSheet()->getStyle('A3')
        $current_style = $sheet->getStyle($start_cell.':'.$end_cell);
        $sheet->rangeToArray("A1:Z10", null, true, false, false);
        $current_style->applyFromArray($styleArray);


//        $name_file = $customer->name.'_report_disinfectant_from_'.$from_datetime.'_to_'.$to_datetime;
//
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="'.$name_file.'"');
//        header('Cache-Control: max-age=0');
//
//        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//        $writer->save('php://output');

        $name_file = 'test.pdf';
//        header('Content-Type: application/pdf');
//        header('Content-Disposition: attachment;filename="'.$name_file.'"');
//        header('Cache-Control: max-age=0');

        //$class = Mpdf::class;
        //IOFactory::registerWriter('Pdf', $class);
        //$writer = IOFactory::createWriter($spreadsheet, 'Pdf');
        $writer = new Mpdf($spreadsheet);
        ini_set("pcre.backtrack_limit", "5000000");
        $writer->save(\Yii::$app->basePath.'/'."05featuredemo.pdf");
        //$xmlWriter =  IOFactory::createWriter($spreadsheet , 'Mpdf');
        //$xmlWriter->save(\Yii::$app->basePath.'/'.$name_file);
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