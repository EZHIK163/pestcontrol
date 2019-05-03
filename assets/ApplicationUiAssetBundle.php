<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Содержит список подключаемых CSS и JS конфигураций
 */
class ApplicationUiAssetBundle extends AssetBundle
{
    public $sourcePath = '@app/assets/ui';
    public $css = [
        'css/css.css',
        'css/ext_tss.css',
        'css/my_css.css',
        'css/style.css',
        'css/template.css',
        'css/css_for_drag_n_drop.css'
    ];
    public $js = [
        'js/polyfill.js',
        'js/bootstrap.js',
        'js/interact.min.js',
        'js/mootools-core.js',
        'js/mootools-more.js',
        'js/slider.js',
        'js/template.js',
        'js/new_my.js',
        'js/siblings.js',
        'js/axios.min.js',
        'js/print.js'

    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
