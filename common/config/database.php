<?php
return 
[
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbName . '',
    'emulatePrepare' => true,
    'username' => $dbUser,
    'password' => $dbPass,
    'charset' => 'utf8',
];