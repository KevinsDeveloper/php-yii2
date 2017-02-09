<?php

require(__DIR__ . '/loader.php');

return [
    'id'                  => 'resque',
    'basePath'            => dirname(__DIR__) . "/",
    'defaultRoute'        => 'run/worker',
    'controllerNamespace' => 'task\resque\controllers',
    'language'            => 'zh-CN',
    'bootstrap'           => ['log'],
    'components'          => [
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
    ],
    'params'              => require(__DIR__ . '/params.php'),
];
