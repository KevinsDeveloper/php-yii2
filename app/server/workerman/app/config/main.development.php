<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */
require_once(__DIR__ . '/loader.php');


return [
    'id'                  => 'workerman',
    'basePath'            => dirname(__DIR__) . "/",
    'defaultRoute'        => 'run/index',
    'controllerNamespace' => 'server\workerman\app\controllers',
    'language'            => 'zh-CN',
    'bootstrap'           => ['log'],
    'components'          => [
        'db'           => require_once LIB . DS . 'config' . DS . 'db.php',
        'redis'        => require_once LIB . DS . 'config' . DS . 'redis.php',
        'request'      => ['class' => 'yii\console\Request'],
        'response'     => ['class' => 'yii\console\Response'],
        'errorHandler' => ['class' => 'yii\console\ErrorHandler'],
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
                'from'    => ['' => '']
            ],
        ],
        'log'          => [
            'targets' => [
                'file' => [
                    'class'      => 'yii\log\FileTarget',
                    'levels'     => ['error', 'warning', 'profile', 'info'],
                    'categories' => ['yii\*'],
                ],
            ],
        ],
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ]
            ],
        ],
        'encrypt'      => [
            'class' => 'lib\vendor\encrypt\Encrypt',
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
];
