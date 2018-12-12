<?php
namespace app\components;

use Ghunti\HighchartsPHP\Highchart;
use yii\base\Widget;

class GraphWidget extends Widget
{
    public $data;
    public function run()
    {
        $chart = new Highchart();
        $chart->title->text = 'Monthly Average Temperature';
        $chart->title->x = -20;

        $chart->series[0] = ['name' => 'Tokyo', 'data' => array(7.0, 6.9, 9.5)];

        $chart->printScripts();

        echo '<script type=\"text/javascript\"><?php echo $chart->render("chart"); ?></script>';
        //echo $chart->render("chart");
    }
}
