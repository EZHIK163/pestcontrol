<?php


namespace app\assets;

use yii\web\AssetBundle;

/**
 *
 * ChartPluginAsset
 */
class InteractAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/ui';

    public $js = [
        'js/interact.min.js',
        'js/test_drag_n_drop.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
        //you can also make it work only in debug mode: 'forceCopy' => YII_DEBUG
    ];
}
