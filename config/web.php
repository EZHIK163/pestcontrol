<?php
return [
    'id'            => 'pestcontrol',
    'basePath'      => realpath(__DIR__.'/../'),
    'language'      => 'ru',
    'components'    => [
        'request'  => [
            'cookieValidationKey'   => 'sdgsgsdfhsdhdfgsddfgtgadxdfgdf'
        ],
        'db'  => require (__DIR__. '/db.php'),
        'urlManager'    => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false
        ],
        'db_old' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'pgsql:host=127.0.0.1;port=5432;dbname=old_pestcontrol',
            'username'  => 'pestcontrol',
            'password'  => 'pestcontrol'
        ],
        'user'  => [
            'identityClass' => 'app\models\user\UserRecord'
        ],
        'authManager' => [
            //'class'         => 'yii\rbac\DbManager',
            'class'         => 'app\utilities\MyRbacManager',
            //'defaultRoles'  => ['guest']
        ]
    ],
    'modules'   => [
        'gii'   => [
            'class' => 'yii\gii\Module',
            'allowedIPs'    => ['*']
        ]
    ],
    'extensions' => require(__DIR__. '/../vendor/yiisoft/extensions.php'),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ]
];