<?php

namespace app\components;

use app\assets\InteractAsset;
use yii\base\Widget;

/**
 * Виджет регистрирующий JS для заполнения точек на схемах точек контроля
 */
class InteractWidget extends Widget
{
    /** @var array */
    public $options = [];
    /** @var array */
    public $clientOptions = [];
    /** @var array */
    public $data = [];
    /** @var int */
    public $id;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
    }

    /**
     * @inheritDoc
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        InteractAsset::register($view);

        $js = "setIdSchemaPointControl({$this->id}); getPoints();";
        $view->registerJs($js);
    }
}
