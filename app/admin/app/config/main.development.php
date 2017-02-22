<?php

/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    kevin
 */
require(__DIR__ . '/loader.php');

return [
    'id'           => 'app',
    'basePath'     => dirname(__DIR__) . "/../",
    'defaultRoute' => 'site/index',
    'language'     => 'zh-CN',
    'bootstrap'    => ['log'],
    'modules'      => [
        'admin'   => ['class' => 'admin\modules\admin\Module'],
        'site'    => ['class' => 'admin\modules\site\Module'],
        'setting' => ['class' => 'admin\modules\setting\SettingModule'],
        'gii'     => [
            'class'      => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '192.168.1.*', '10.0.2.15', '*'],
        ],
    ],
    'as access'    => [
        'class'        => 'admin\modules\admin\components\AccessControl',
        'allowActions' => [
            'gii/*',
            'site/login',
            'site/login/*',
        ],
    ],
    'components'   => [
        'db'           => require_once LIB . '/config/db.php',
        'user'         => [
            'identityClass'   => 'admin\models\AuthUser',
            'enableAutoLogin' => true,
            'idParam'         => '_identity',
            'loginUrl'        => ['site/login'],
        ],
        'authManager'  => [
            //'class' => 'yii\rbac\PhpManager',
            'class' => 'admin\modules\admin\components\DbManager',
        ],
        'request'      => [
            'cookieValidationKey' => '7yD09jK717NU5OgDAS2brZ3mqzrfO1xE5A41jrG90FoxmKixZ2IPNuMDXD3OCAxS',
        ],
        'errorHandler' => [
            'errorAction' => 'site/login/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => false,
                'yii\web\YiiAsset'    => false,
            ],
        ],
        'mailer'       => [
            'class'         => 'yii\swiftmailer\Mailer',
            'transport'     => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.exmail.qq.com',
                'username'   => '',
                'password'   => '',
                'port'       => '25',
                'encryption' => 'tls',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => ['' => ''],
            ],
        ],
        'urlManager'   => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'suffix'          => '', //后缀
            'rules'           => require(__DIR__ . '/rules.php'),
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                'file' => [
                    'class'      => 'yii\log\FileTarget',
                    'levels'     => ['error', 'warning', 'profile', 'info'],
                    'categories' => ['yii\*'],
                ],
            ],
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'view'         => [
            'theme'     => [
                'pathMap' => ['@app/views' => '@app/views'],
                'baseUrl' => '@app/views',
            ],
            'class'     => 'yii\web\View',
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'mcrypt'       => [
            'class' => 'lib\vendor\mcrypt\Mcrypt',
        ],
    ],
    'params'       => require(__DIR__ . '/params.php'),
];
