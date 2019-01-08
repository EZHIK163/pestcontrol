<?php

namespace app\components;

use app\assets\InteractAsset;
use yii\base\Widget;

/**
 *
 * Chart renders a canvas ChartJs plugin widget.
 */
class InteractWidget extends Widget
{
    public $options = [];
    public $clientOptions = [];
    public $data = [];
    public $id;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
    }

    /**
     * Registers the required js files and script to initialize ChartJS plugin
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        InteractAsset::register($view);

        $js = "setIdSchemaPointControl({$this->id}); getPoints();";
        $view->registerJs($js);
    }
}
