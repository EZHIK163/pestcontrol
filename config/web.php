<?php
return [
    'id'            => 'pestcontrol',
    'basePath'      => realpath(__DIR__.'/../'),
    'components'    => [
        'request'  => [
            'cookieValidationKey'   => 'sdgsgsdfhsdhdfgsddfgtgadxdfgdf'
        ],
        'db'  => require (__DIR__. '/db.php')
    ]
];