<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1hFWSdjjM5reF6tp-8KZBKDh4BCfvSVW',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.13', '192.168.0.207', '192.168.0.20'],
        'generators' => [
            'crud' => [
                'class' => 'app\templates\inspinia\crud\Generator',
                'templates' => ['INSPINIA' => '@app/templates/inspinia/crud/default']
            ],
            'model' => [
                'class' => 'app\templates\inspinia\model\Generator',
                'templates' => ['INSPINIA' => '@app/templates/inspinia/model/default']
            ]
        ],
    ];
}

return $config;
