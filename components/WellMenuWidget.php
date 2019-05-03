<?php
namespace app\components;

use stdClass;
use yii\base\Widget;

/**
 * Виджет подменю в левой части сайта
 */
class WellMenuWidget extends Widget
{
    /**
     * @var stdClass
     */
    public $data;

    /**
     * @return string|void
     */
    public function run()
    {
        if (!isset($this->data->items)) {
            return;
        }
        echo '<div class="well _menu"><h3 class="page-header">' .
            $this->data->title . '</h3><ul class="' . $this->data->class_ul . '">';
        foreach ($this->data->items as $item) {
            echo '<li class="' . $this->data->class_li . '"><a href="' . $item['url'] . '">• ' . $item['name'] . '</a></li>';
        }
        echo '</ul></div>';
    }
}
