<?php

namespace app\modules\pilot\controllers;

use app\models\Flights;
use app\models\Schedule;
use app\models\User;
use app\models\UserPilot;
use app\models\Booking;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRoster()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find()->joinWith('pilot')->joinWith('pilot.rank')->andWhere(
                    ['status' => UserPilot::STATUS_ACTIVE]
                )
        ]);

        $dataProvider->sort->attributes['pilot.location'] = [
            'asc' => ['user_pilot.location' => SORT_ASC],
            'desc' => ['user_pilot.location' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['pilot.rank.name_en'] = [
            'asc' => ['ranks.name_en' => SORT_ASC],
            'desc' => ['ranks.name_en' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['pilot.rank.name_ru'] = [
            'asc' => ['ranks.name_ru' => SORT_ASC],
            'desc' => ['ranks.name_ru' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['pilot.staff_comments'] = [
            'asc' => ['user_pilot.staff_comments' => SORT_ASC],
            'desc' => ['user_pilot.staff_comments' => SORT_DESC]
        ];

        return $this->render('roster', ['dataProvider' => $dataProvider]);
    }

    public function actionBooking()
    {
        \Yii::$app->user->returnUrl = '/pilot/booking';

        if (!$model = Booking::find()->andWhere(['user_id' => \Yii::$app->user->id])->one()) {
            $model = new Booking();
            $model->addData();
        }

        if (isset($_POST['Booking'])) {
            $model->attributes = $_POST['Booking'];
            $model->status = 1;
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
            'profile',
            [
                'user' => $user,
                'flightsProvider' => $flightsProvider
            ]
        );
    }

    public function actionCenter()
    {
        $user = Users::find()->andWhere(['vid' => Yii::$app->user->identity->vid])->one();

        $flightsProvider = new ActiveDataProvider([
            'query' => Flights::find()->where(['user_id' => $user->vid])->limit(6),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render(
            'center/index',
            [
                'user' => $user,
                'flightsProvider' => $flightsProvider
            ]
        );
    }

    public function actionEdit($id=null)
    {
        if(!$id) $id=Users::getAuthUser()->vid;
        $user = Users::find()->andWhere(['vid' => $id])->one();
        if (!$user) {
            throw new \yii\web\HttpException(404, 'User not found');
        }

        $user->scenario = Users::SCENARIO_EDIT;

        if ($user->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($user, 'avatar')) {
                $user->avatar = UploadedFile::getInstance($user, 'avatar');
                if (in_array($user->avatar->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/avatars/');
                    $extension = $user->avatar->extension;
                    $user->avatar->name = md5($user->avatar->baseName);
                    $user->avatar->saveAs($dir . $user->avatar->name . "." . $extension);
                    $user->avatar = $user->avatar->name . "." . $extension;
                }
            }
            if (!$user->validate()) {
                throw new \yii\web\HttpException(404, 'be');
            }
            $user->save();
            return $this->redirect(['center']);
        } else {
            return $this->render('edit', ['user' => $user]);
        }
    }
}
