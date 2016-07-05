<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    public $css = [
        'css/site.css',
        'css/bootstrap-switch.min.css',
        'css/jquery.fancybox.css',
        'css/select2.min.css',
        'libs/font_awesome/css/font-awesome.min.css',
        'dist/css/skins/_all-skins.min.css',
        'dist/css/admin.min.css'
    ];
    public $js = [
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'bootstrap/js/bootstrap.min.js',
        'js/bootstrap-switch.min.js',
        'js/jquery.fancybox.js',
        'js/select2.min.js',
        'libs/tinymce/tinymce.min.js',
        'js/jquery.uploadfile.min.js',
        'dist/js/app.min.js',
        'dist/js/demo.js',
        'js/custom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
