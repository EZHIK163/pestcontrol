<?php
return [
    'id'            => 'pestcontrol-console',
    'basePath'      => dirname(__DIR__),
    'components'    => [
        'db'  => require(__DIR__. '/db.php'),
        'authManager' => [
            'class'         => 'app\utilities\MyRbacManager',
            'defaultRoles'  => ['guest']
        ],
        'db_old' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'pgsql:host=db;port=5432;dbname=pestcontrol_old',
            'username'  => 'pestcontrol_old',
            'password'  => 'pestcontrol_old'
        ],
        'db_old_mysql' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'mysql:host=127.0.0.1;port=5432;dbname=old_pestcontrol',
            'username'  => 'pestcontrol',
            'password'  => 'pestcontrol'
        ]
    ],
    'bootstrap' => [
        'log',
        'app\bootstrap\ContainerBootstrap',
    ],
    'controllerMap' => [
        'deactivate-point-status' => [
            'class' => \app\commands\DeactivateStatusCaughtCommand::class
        ],
    ]
];
