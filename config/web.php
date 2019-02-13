<?php
return [
    'id'            => 'pestcontrol',
    'basePath'      => realpath(__DIR__.'/../'),
    'language'      => 'ru',
    'components'    => [
        'request'  => [
            'cookieValidationKey'   => 'sdgsgsdfhsdhdfgsddfgtgadxdfgdf',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'db'  => require(__DIR__. '/db.php'),
        'urlManager'    => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
            'rules' => [
                'andr/create_point.php'              => 'account/new-point/',
                'manager-event/new-event'            => 'account/new-event'
            ]
        ],
        'db_old' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'pgsql:host=127.0.0.1;port=5432;dbname=old_pestcontrol',
            'username'  => 'pestcontrol',
            'password'  => 'pestcontrol'
        ],
        'user'  => [
            'identityClass' => 'app\entities\UserRecord'
        ],
        'authManager' => [
            'class'         => 'app\utilities\MyRbacManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host'      => getenv('email_server_host'),
                'username'  => getenv('email_server_username'),
                'password'  => getenv('email_server_password'),
                'port'      => getenv('email_server_port'),
                'encryption' => 'tls',
            ],
        ],
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
    ],
    'bootstrap' => [
        'log',
        'app\bootstrap\ContainerBootstrap',
    ],
    'params'    => [
        'email_notify'  => explode(',', getenv('email_notify')),
        'email_from'    => getenv('email_from')
    ]
];
