<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Billing;
use app\models\BillingPayments;
use app\models\BillingUserBalance;
use app\models\UserPilot;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;
use yii\web\User;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\commands\ParseController;

use app\models\Events\Events;
use app\models\Events\Calendar;

/**
 * Class SiteController
 * @package app\controllers
 */
class ApiController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionEvents()
    {
        echo json_encode(
            [
                'events' => Events::center(true),
                'eventsCalendar' => Calendar::center()
            ]
        );
    }

    public function actionBriefing($id){
        $fleet = \app\models\Fleet::find()->where(['regnum' => $id])->one();
        if($fleet){
            $id = $fleet->id;
            $brif = new \app\components\Briefing($id);
            echo json_encode($brif->getRemarks());
        }else{
            echo json_encode("REG/{$id} OPR/AFLGROUP");
        }
    }
}
