<?php

namespace app\modules\pilot\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\Services\notifications\Notification;

/**
 * Notification
 */
class NotificationsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        Notification::read();

        return $this->render('index', [
            'notifications' => Notification::userList(),
        ]);
    }


}
