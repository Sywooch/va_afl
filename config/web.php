<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(require(__DIR__ . '/params.php'), require(__DIR__ . '/globalparams.php'));

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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'constructArgs' => ['localhost', 25],
            ],
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
                '' => 'site/index',
                '<module:screens>/<action:(view|create|user|top)>' => '<module>/default/<action>',
                '<module:screens>/<action:(view|create|user|top)>/<id:\w+>' => '<module>/default/<action>',
                '<module:screens>' => '<module>/default/index',
                '<module:screens>/<action:\.*>' => '<module>/default/index',
                '<module:events>/<action:(create|delete|update)>' => '<module>/default/<action>',
                '<module:events>/<action:(create|delete|update)>/<id:\w+>' => '<module>/default/<action>',
                '<module:events>/<id:\w+>' => '<module>/default/view',
                '<module:events>' => '<module>/default/index',
                '<module:events>/<action:\.*>' => '<module>/default/index',
                '<module:content>/categories' => '<module>/categories/index',
                '<module:content>/categories/<action:\.*>' => '<module>/categories/index',
                '<module:content>/categories/<action:\w+>/<id:\w+>' => '<module>/categories/<action>',
                '<module:content>/categories/<action:\w+>' => '<module>/categories/<action>',
                '<module:content>/<action:\w+>' => '<module>/default/<action>',
                '<module:content>/<action:\w+>/<id:\w+>' => '<module>/default/<action>',
                '<module:content>' => '<module>/default/index',
                '<module:content>/<action:\.*>' => '<module>/default/index',
                '<module:pilot|fleet|events|squadron>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:pilot|fleet|events|squadron>/<action:\w+>' => '<module>/default/<action>',
                '<module:pilot|airline|fleet|events|admin|squadron>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
                '<module:pilot|airline|fleet|events|admin|squadron>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:pilot|airline|fleet|events|admin|squadron>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:content|pilot|fleet|events|squadron>' => '<module>/default/index',
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
        'events' => [
            'class' => 'app\modules\events\Module',
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
                    'idField' => 'vid', // id field of your User model that corresponds to Yii::$app->user->id
                    'usernameField' => 'full_name', // username field of your User model
                ],
            ],
        ],
        'content' => [
            'class' => 'app\modules\content\Module',
        ],
        'screens' => [
            'class' => 'app\modules\screens\Module',
        ],
    ],
    'params' => $params,
    'on beforeAction' => function ($event) {
        if (!Yii::$app->user->isGuest) {
            if (!in_array(Yii::$app->user->id, Yii::$app->params['whitelist'])) {
                throw new \yii\web\HttpException(401, 'Not allowed');
            }
            Yii::$app->layout = 'main';
        }
        if (Yii::$app->user->isGuest) {
            if ((Yii::$app->controller->id != 'api' && Yii::$app->controller->id != 'site') || (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'index') && (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'login')) {
                Yii::$app->getResponse()->redirect('/site/index');
            }
        }
        if (!Yii::$app->user->isGuest && !in_array($event->action->id, ['edit', 'toolbar', 'getservertime'])) {
            \app\models\User::checkEmail();
            $user = \app\models\Users::getAuthUser();
            $user->last_visited = date('Y-m-d H:i:s');
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
