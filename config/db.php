<?php
return [
    'class'     => 'yii\db\Connection',
    'dsn'       => getenv('db_dsn'),
    'username'  => getenv('db_username'),
    'password'  => getenv('db_password'),
];
