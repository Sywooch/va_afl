<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
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
            'enableStrictParsing' => false,
			'rules' => [
				'<module:pilot|airline|fleet|events>/<action:\w+>' => '<module>/default/<action>',
				'<module:pilot|airline|fleet|events>/<action:\w+>/<id:\w+>' => '<module>/default/<action>',
				'<module:pilot|airline|fleet|events|admin>/<controller:\w+>' => '<module>/<controller>/index',
				'<module:pilot|airline|fleet|events|admin>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
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
			if (!Yii::$app->user->isGuest && $event->action->id != 'editprofile')
				\app\models\User::checkEmail();
            \app\models\User::setLanguage();
		},
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
		'allowedIPs' => ['*'],
	];
}

return $config;
