<?php
require_once(dirname(__FILE__) . '/constants.php');
//die(YII_DEBUG);
return [
    'id' => 'GRDJournals',
    'timezone' => 'Asia/Kolkata',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'page/index',
    'bootstrap' => ['log'],
    'name' => $productName,
    'language' => 'en-US',
    'components' => [
        'view' => [
            'class' => 'backend\components\View',
            'enableMinify' => true,
            'web_path' => '@web', // path alias to web base
            'base_path' => '@webroot', // path alias to web base
            'minify_path' => '@webroot/minify', // path alias to save minify result
            'js_position' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'force_charset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expand_imports' => true, // whether to change @import on content
            'compress_output' => true, // compress result html page
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => ($hostName == "localhost")?[
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mailgun.org',
                'username' => 'postmaster@mg.grdjournals.com',
                'password' => '6aae26e18d3a4f606994cdcc3a65f321',
                'port' => '587',
                //'encryption' => 'tls',
                ] : [

                'class' => 'Swift_SmtpTransport',
                'host' => 'server.grdjournals.com',
                'username' => 'info@grdjournals.com',
                'password' => '#MadDam@1234',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'useFileTransport' => FALSE,
        ],
        'i18n' => array(
            'translations' => array(
                'app' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => array(
                        'app' => 'app.php',
                        'authorization' => 'authorization.php'
                    )
                ),
                /*'yii' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => array(
                        'yii' => 'yii.php',
                        'authorization' => 'authorization.php',
                        'app' => 'app.php',
                    )
                )*/
            )
        ),
        'db' => require_once (dirname(__DIR__).'/common/config/database.php'),
        'user' => [
            'identityClass' => 'common\models\User',
            'class' => 'app\components\WebUser',
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => array_merge(require(dirname(__FILE__) . '/menu.php'),[
		        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ]),
        ],
        'urlManagerFrontend' => [
            'baseUrl' => DOCURL,
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => array_merge(require(dirname(__FILE__) . '/menu.php'),[
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ]),
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'common' => [
            'class' => 'common\models\common'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
    ],
    'params' => array_merge( require(__DIR__ . '/params.php')),
];
