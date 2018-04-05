<?php
namespace app\assets;

use yii\web\AssetBundle;

class ApplictionUiAssetBundle extends AssetBundle {
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
        //'js/caption.js',
        //'js/core.js',
        //'js/ext_tss.js',
        //'js/html5fallback.js',
        //'js/jquery-migrate-1.js',
        //'js/jquery.min.js',
        //'js/jquerynoconflict.js',
        'js/mootools-core.js',
        'js/mootools-more.js',
        //'js/powertools-1.js',
        'js/slider.js',
        'js/template.js',
        //'js/watch.js',
        'js/new_my.js',
        //'js/my.js',
        'js/siblings.js',
        'js/axios.min.js'

    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
        //you can also make it work only in debug mode: 'forceCopy' => YII_DEBUG
    ];
}