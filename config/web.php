<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'landing',
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hGvobqpSxHXAcz-wxuwnp_TC8AOiaI88',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '<module:pilot|fleet|events|squadron>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:pilot|fleet|events|squadron>/<action:\w+>' => '<module>/default/<action>',
                '<module:pilot|airline|fleet|events|squadron|admin>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
                '<module:pilot|airline|fleet|events|squadron|admin>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:pilot|airline|fleet|events|squadron|admin>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ]
    ],
    'modules' => [
        'pilot' => [
            'class' => 'app\modules\pilot\Module',
        ],
        'airline' => [
            'class' => 'app\modules\airline\Module',
        ],
        'fleet' => [
            'class' => 'app\modules\fleet\Module',
        ],
        'squadron' => [
            'class' => 'app\modules\squadron\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\Users', // fully qualified class name of your User model
                    'idField' => 'vid',        // id field of your User model that corresponds to Yii::$app->user->id
                    'usernameField' => 'full_name', // username field of your User model
                ],
            ],

        ]
    ],
    'params' => $params,
    'on beforeAction' => function ($event) {
        if (!Yii::$app->user->isGuest) {
            if(!in_array(Yii::$app->user->id,Yii::$app->params['whitelist']))
                throw new \yii\web\HttpException(401,'Not allowed');
            Yii::$app->layout = 'main';
        }
        if (!Yii::$app->user->isGuest && !in_array($event->action->id,['edit','toolbar','getservertime'])) {
            \app\models\User::checkEmail();
            $user=\app\models\Users::getAuthUser();
            $user->last_visited=date('Y-m-d H:i:s');
            $user->save();
        }
        \app\models\User::setLanguage();
    },
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
