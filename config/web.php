<?php
return [
    'id'            => 'pestcontrol',
    'basePath'      => realpath(__DIR__.'/../'),
    'components'    => [
        'request'  => [
            'cookieValidationKey'   => 'sdgsgsdfhsdhdfgsddfgtgadxdfgdf'
        ],
        'db'  => require (__DIR__. '/db.php'),
        'urlManager'    => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false
        ],
        'user'  => [
            'identityClass' => 'app\models\user\UserRecord'
        ],
        'authManager' => [
            'class'         => 'yii\rbac\DbManager',
            'defaultRoles'  => ['guest']
        ]
    ],
    'modules'   => [
        'gii'   => [
            'class' => 'yii\gii\Module',
            'allowedIPs'    => ['*']
        ]
    ],
    'extensions' => require(__DIR__. '/../vendor/yiisoft/extensions.php')
];