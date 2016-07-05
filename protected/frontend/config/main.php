<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'upload' => [
            'class' => 'frontend\modules\upload\Module',
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/themes/default/views'],
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable r= routes
            'enablePrettyUrl' => true,
            'showScriptName' => false, // Disable index.php
            'enablePrettyUrl' => true, // Disable r= routes
            'rules' => [
                 'login' => 'login/index',
                'signup' => 'signup/index',
                'profile' => 'profile/index',
                'category/<slug>' => 'post/category',
                '<slug>' => 'post/view',
                'upload/<controller:\w+>/<action:\w+>/<id:\w+>' => 'upload/<controller>/<action>',
                'upload/<controller:\w+>/<action:\w+>' => 'upload/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'session' => [
            'name' => '_frontendSessionId', // unique for frontend
            'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'convert' => [
            'class' => 'frontend\components\Convert',
        ],
        'parsedown' => [
            'class' => 'frontend\components\Parsedown',
        ],
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => $params,
];
