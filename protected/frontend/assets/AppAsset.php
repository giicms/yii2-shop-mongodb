<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    public $css = [
        'css/select2.min.css',
        'css/reset.css',
        'css/style.css',
        'css/site.css',
        'css/simplemde.min.css',
        'font_awesome/css/font-awesome.min.css'
    ];
    public $js = [
        'js/select2.min.js',
        'js/simplemde.min.js',
        'js/jquery.mobile.custom.min.js',
        'js/jquery.uploadfile.min.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
