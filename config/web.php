<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'bootstrap' => ['log', \app\bootstrap\Bootstrap::class],
    'aliases' => [
        '@runtime' => dirname(__DIR__) . '/runtime',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                yii\web\JqueryAsset::class => false
            ]
        ],
        'request' => [
            'cookieValidationKey' => 'yes-it-is-absolutely-random',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            '__class' => \yii\log\Logger::class,
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            yii\web\JqueryAsset::class => function () {
                return new \yii\web\AssetBundle();
            }
        ]
    ]
];

if (false) { // Enable when speaker asks to
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];
}

return $config;
