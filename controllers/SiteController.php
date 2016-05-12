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

use app\components\UserRoutes;
use app\models\Airports;
use app\models\Booking;
use app\models\ContactForm;
use app\models\Fleet;
use app\models\IvaoLogin;
use app\models\Pax;
use app\models\Schedule;
use app\models\Users;
use app\models\Actypes;
use app\models\Flights;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
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

    public function actionIndex()
    {

        if(Yii::$app->user->isGuest) {
            $onlineProvider = new ActiveDataProvider([
                'query' => Flights::find()->where(['status' => Flights::FLIGHT_STATUS_STARTED]),
                'sort' => false,
                'pagination' => false,
            ]);
            return $this->render('index', ['onlineProvider' => $onlineProvider]);
        } else {
            $this->redirect('pilot/center');
        }
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
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
        $this->goHome();

        return 1;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
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

    public function actionGetacfregnums($q = null)
    {
        echo Fleet::getForBooking($q);
    }

    public function actionDeletemybooking()
    {
        if ($user = Yii::$app->user) {
            $booking = Booking::find()->andWhere(['user_id' => $user->id])->andWhere('status < '.Booking::BOOKING_FLIGHT_END)->one();
            $booking->status = Booking::BOOKING_DELETED_BY_USER;
            $booking->save();
        }

        $this->goBack();
    }

    /**
     * Маршруты пользователя
     */
    public function actionGetuserroutes($id)
    {
        echo json_encode((new UserRoutes($id))->getAsArray());
    }

    public function actionGetairportpaxdetail($airport, $paxtype)
    {
        echo Pax::detailList($airport, $paxtype);
    }

    public function actionGetservertime()
    {
        echo gmdate("F j, Y G:i:s");
    }

    public function actionPaxdata()
    {
        echo Pax::jsonMapData();
    }

    public function actionSmartbooking($icao)
    {
        echo json_encode(Booking::smartBooking($icao));
    }

    public function actionMybookingdetails()
    {
        echo Booking::jsonMapData();
    }

    public function actionCalctaxiprice()
    {
        $to = $_POST['to'];
        $from = Users::getAuthUser()->pilot->location;
        $money = Helper::calcTaxiPrice($from, $to);
        $valid = BillingUserBalance::checkHavingMoney(Users::getAuthUser()->vid, $money);
        echo json_encode(['msg' => "COST for this flight is: <b>$money</b>VUC's", 'valid' => $valid]);
    }

    public function actionDotaxi()
    {
        $to = $_POST['to'];
        $from = Users::getAuthUser()->pilot->location;
        $money = Helper::calcTaxiPrice($from, $to);
        $valid = BillingUserBalance::checkHavingMoney(Users::getAuthUser()->vid, $money);
        if ($valid) {
            Users::transfer(Users::getAuthUser()->vid, $to);
            BillingPayments::registerTaxiPayment(Users::getAuthUser()->vid, $money);
        }
    }
}
