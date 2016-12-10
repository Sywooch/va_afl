<?php

namespace app\modules\airline\controllers;

use app\models\Events\EventsMembers;
use app\models\Flights;
use app\models\Suspensions;
use Yii;
use app\models\Log;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class StatsController extends Controller
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
        return $this->render('index', [
            'flights' => Flights::stats(0,'asc')['all'],
            'suspensions' => Suspensions::stats(0,'asc'),
            'events' => EventsMembers::stats(0,'asc'),
        ]);
    }
}
