<?php

namespace app\controllers;

use app\models\Airports;
use app\models\Booking;
use app\models\ContactForm;
use app\models\Fleet;
use app\models\IvaoLogin;
use app\models\Users;
use app\models\Actypes;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\User;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin($IVAOTOKEN = null)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!$IVAOTOKEN) {
            return $this->redirect(Yii::$app->params['ivao_login_url']);
        }
        $model = new IvaoLogin;
        $model->login($IVAOTOKEN);
        $this->redirect(Yii::$app->user->returnUrl);

        return 1;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render(
            'contact',
            [
                'model' => $model,
            ]
        );
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGetairports($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Airports::searchByICAO($q, $id);
    }

    public function actionGetacftypes($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Actypes::searchByICAO($q, $id);
    }

    public function actionGetacfregnums()
    {
        echo Fleet::getForBooking();
    }

    public function actionDeletemybooking()
    {
        if ($user = Yii::$app->user) {
            $booking = Booking::find()->andWhere(['user_id' => $user->id])->one();
            $booking->delete();
        }
        $this->goBack();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
}
