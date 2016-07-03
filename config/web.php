<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(require(__DIR__ . '/params.php'), require(__DIR__ . '/globalparams.php'));

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'landing',
    'language' => 'en',
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en-US', // Developer language
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => true,
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
            'enableSwiftMailerLogging' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['yii\swiftmailer\Logger::add'],
                ],
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
                '<module:users>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
                '<module:users>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:users>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:screens>/<action:(view|create|user|top|delete)>' => '<module>/default/<action>',
                '<module:screens>/<action:(view|create|user|top|delete)>/<id:\w+>' => '<module>/default/<action>',
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
                '<module:pilot|airline|fleet|events|admin|squadron|translatemanager>/<controller:\w+>/<action:\w+>/<id:\w+>' => '<module>/<controller>/<action>',
                '<module:pilot|airline|fleet|events|admin|squadron|translatemanager>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:pilot|airline|fleet|events|admin|squadron|translatemanager>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:content|pilot|fleet|events|squadron>' => '<module>/default/index',
                '<module:tours>/<action:\w+>' => '<module>/default/<action>',
                '<module:tours>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:tours>' => '<module>/default/index',
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
        'users' => [
            'class' => 'app\modules\users\Module',
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
        'tours' => [
            'class' => 'app\modules\tours\Module',
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'root' => '@app',
            // The root directory of the project scan.
            'scanRootParentDirectory' => false,
            // Whether scan the defined `root` parent directory, or the folder itself.
            // IMPORTANT: for detailed instructions read the chapter about root configuration.
            'layout' => 'language',
            // Name of the used layout. If using own layout use 'null'.
            'allowedIPs' => ['*'],
            // IP addresses from which the translation interface is accessible.
            'roles' => ['@'],
            // For setting access levels to the translating interface.
            'tmpDir' => '@runtime',
            // Writable directory for the client-side temporary language files.
            // IMPORTANT: must be identical for all applications (the AssetsManager serves the JavaScript files containing language elements from this directory).
            'phpTranslators' => ['::t'],
            // list of the php function for translating messages.
            'jsTranslators' => ['lajax.t'],
            // list of the js function for translating messages.
            'patterns' => ['*.js', '*.php'],
            // list of file extensions that contain language elements.
            'ignoredCategories' => ['yii'],
            // these categories won't be included in the language database.
            'ignoredItems' => ['config'],
            // these files will not be processed.
            'scanTimeLimit' => null,
            // increase to prevent "Maximum execution time" errors, if null the default max_execution_time will be used
            'searchEmptyCommand' => '!',
            // the search string to enter in the 'Translation' search field to find not yet translated items, set to null to disable this feature
            'defaultExportStatus' => 1,
            // the default selection of languages to export, set to 0 to select all languages by default
            'defaultExportFormat' => 'json',
            // the default format for export, can be 'json' or 'xml'
            'tables' => [                   // Properties of individual tables
                [
                    'connection' => 'db',   // connection identifier
                    'table' => '{{%language}}',         // table name
                    'columns' => ['name', 'name_ascii'],// names of multilingual fields
                    'category' => 'database-table-name',// the category is the database table name
                ]
            ]
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
            /*if ((Yii::$app->controller->id != 'api' && Yii::$app->controller->id != 'site')
                || (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'index')
                && (Yii::$app->controller->id != 'auth')) {
                Yii::$app->getResponse()->redirect('/site/index');
            }*/
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
