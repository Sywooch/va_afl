<?php

namespace app\modules\pilot\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\swiftmailer\Mailer;
use yii\web\UserEvent;

use app\commands\ParseController;
use app\models\Flights;
use app\models\Schedule;
use app\models\User;
use app\models\UserPilot;
use app\models\Booking;
use app\models\Users;
use app\models\Content;
use app\models\EmailConfirm;
use app\models\Events\Events;
use app\models\Events\Calendar;
use app\models\BillingPayments;
use app\models\Staff;


class DefaultController extends Controller
{
    public function actionRoster()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find()->joinWith('pilot')->joinWith('pilot.billingUserBalance')->andWhere(
                    ['status' => UserPilot::STATUS_ACTIVE]
                ),
            'pagination' => array('pageSize' => 100),
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_ASC]]
        ]);

        $dataProvider->sort->attributes['pilot.location'] = [
            'asc' => ['user_pilot.location' => SORT_ASC],
            'desc' => ['user_pilot.location' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['pilot.level'] = [
            'asc' => ['user_pilot.experience' => SORT_ASC],
            'desc' => ['user_pilot.experience' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['pilot.billingUserBalance'] = [
            'asc' => ['billing_user_balance.balance' => SORT_ASC],
            'desc' => ['billing_user_balance.balance' => SORT_DESC]
        ];

        return $this->render('roster', ['dataProvider' => $dataProvider]);
    }

    public function actionBooking()
    {
        \Yii::$app->user->returnUrl = '/pilot/booking';

        if (!$model = Booking::find()->andWhere(['user_id' => \Yii::$app->user->id])->andWhere('status < '.Booking::BOOKING_FLIGHT_END)->one()) {
            $model = new Booking();
            $model->addData();
        }

        if (isset($_POST['Booking'])) {
            $model->attributes = $_POST['Booking'];
            $model->status = Booking::BOOKING_INIT;
            $model->save();
            $this->refresh();
        }

        $scheduledp = new ActiveDataProvider([
            'query' => Schedule::find()->andWhere('dep = "' . $model->from_icao . '"')
                    ->andWhere('dep_utc_time > "' . gmdate('H:i:s') . '"')
                    ->andWhere('SUBSTRING(day_of_weeks,' . (gmdate('N') - 1) . ',1) = 1')
                    ->andWhere('start < "' . gmdate('Y-m-d') . '"')
                    ->andWhere('stop > "' . gmdate('Y-m-d') . '"')
                    ->orderBy('dep_utc_time'),
            'pagination' => ['pageSize' => 6],
        ]);

        return $this->render('booking_new', ['model' => $model, 'scheduledp' => $scheduledp]);
    }

    public function actionProfile($id = null)
    {
        if (!$id) {
            $this->redirect(Url::to('/pilot/center'));
        }

        $user = Users::find()->andWhere(['vid' => $id])->one();

        if(!$user || ($user->pilot->status == UserPilot::STATUS_DELETED && !Yii::$app->user->can('user_pilot/profileview/status/deleted'))){
            throw new \yii\web\HttpException(404, Yii::t('app', 'User Not Found'));
        }

        $flightsProvider = new ActiveDataProvider([
            'query' => Flights::find()->where(['user_id' => $user->vid])->orderBy(['id' => SORT_DESC])->limit(6),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render(
            'profile/index',
            [
                'user' => $user,
                'flightsProvider' => $flightsProvider,
                'staff' => Staff::byUser($id)
            ]
        );
    }

    public function actionBalance($id){
        if($id != Yii::$app->user->identity->vid && !Yii::$app->user->can('billing/user/view_balance')){
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        $dataProvider = new ActiveDataProvider([
            'query' => BillingPayments::find()->where(['user_id' => $id])->orderBy(['id' => SORT_DESC])
        ]);

        return $this->render('balance', ['dataProvider' => $dataProvider]);
    }

    public function actionCenter()
    {
        $user = Users::find()->andWhere(['vid' => Yii::$app->user->identity->vid])->one();

        $flightsProvider = new ActiveDataProvider([
            'query' => Flights::find()->where(['user_id' => $user->vid])->limit(6),
            'sort' => false,
            'pagination' => false,
        ]);

        $onlineProvider = new ActiveDataProvider([
            'query' => Booking::find()->where('status > 0')->andWhere('status < 3'),
            'sort' => false,
            'pagination' => false,
        ]);

        $topProvider = new ActiveDataProvider([
            'query' => Users::find()->joinWith('pilot')->joinWith('pilot.billingUserBalance')->andWhere(
                    ['status' => UserPilot::STATUS_ACTIVE]
                ),
            'pagination' => array('pageSize' => 10),
            'sort'=> ['defaultOrder' => ['pilot.level'=>SORT_DESC]]
        ]);

        $topProvider->sort->attributes['pilot.location'] = [
            'asc' => ['user_pilot.location' => SORT_ASC],
            'desc' => ['user_pilot.location' => SORT_DESC]
        ];
        $topProvider->sort->attributes['pilot.level'] = [
            'asc' => ['user_pilot.experience' => SORT_ASC],
            'desc' => ['user_pilot.experience' => SORT_DESC]
        ];

        $topProvider->sort->attributes['pilot.billingUserBalance'] = [
            'asc' => ['billing_user_balance.balance' => SORT_ASC],
            'desc' => ['billing_user_balance.balance' => SORT_DESC]
        ];

        return $this->render(
            'center/index',
            [
                'user' => $user,
                'news' => Content::news(),
                'events' => Events::center(),
                'eventsCalendar' => Calendar::center(),
                'flightsProvider' => $flightsProvider,
                'onlineProvider' => $onlineProvider,
                'topProvider' => $topProvider
            ]
        );
    }

    public function actionIndex()
    {
        $user = Users::find()->where(['vid' => Yii::$app->user->identity->vid])->one();

        return $this->render(
            'index',
            ['user' => $user]
        );
    }

    public function actionEdit($id = null)
    {
        if(!$id) $id=Users::getAuthUser()->vid;
        $pilot = UserPilot::find()->andWhere(['user_id' => $id])->one();

        if (!$pilot) {
            throw new \yii\web\HttpException(404, 'User not found');
        }

        if ($pilot->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($pilot, 'avatar')) {
                $pilot->avatar = UploadedFile::getInstance($pilot, 'avatar');
                if (in_array($pilot->avatar->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/avatars/');
                    $extension = $pilot->avatar->extension;
                    $pilot->avatar->name = md5($pilot->avatar->baseName);
                    $pilot->avatar->saveAs($dir . $pilot->avatar->name . "." . $extension);
                    $pilot->avatar = $pilot->avatar->name . "." . $extension;
                }
            }

            if (!$pilot->validate()) {
                throw new \yii\web\HttpException(404, 'be');
            }

            $pilot->save();
            return $this->redirect(['/pilot/center']);
        } else {
            return $this->render('edit', ['pilot' => $pilot]);
        }
    }

    public function actionSettings($id = null)
    {
        if(!$id) $id=Users::getAuthUser()->vid;
        $user = Users::find()->andWhere(['vid' => $id])->one();
        if (!$user) {
            throw new \yii\web\HttpException(404, 'User not found');
        }
        $user->scenario = Users::SCENARIO_EDIT;
        $old_mail = $user->email;

        if ($user->load(Yii::$app->request->post())) {
            if ($user->email != $old_mail)
            {
                $pilot = UserPilot::find()->where(['user_id' => $user->vid])->one();
                $token = Yii::$app->security->generateRandomString();
                $pilot->email_token = $token;
                Yii::$app->mailer->compose('emailConfirm.php', ['user' => $user, 'token' => $token])
                    ->setFrom('noreply@va-transaero.ru')
                    ->setTo($user->email)
                    ->setSubject('Потверждение учетной записи')
                    ->send();

                $pilot->status = UserPilot::STATUS_PENDING;
                $pilot->save();
            }
            if (!$user->validate()) {
                throw new \yii\web\HttpException(404, 'be');
            }
            $user->save();
            return $this->redirect(['/pilot/center']);
        } else {
            return $this->render('settings', ['user' => $user]);
        }
    }


    public function actionConfirmtoken($id)
    {
        try {
            $model = new EmailConfirm($id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if($model->confirmEmail()) {
            $this->goHome();
        } else {
            throw new HttpException('500');
        }
    }
}
