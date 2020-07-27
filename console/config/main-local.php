<?php

$config = [

];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
