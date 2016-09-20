<?php

namespace app\modules\airline\controllers;

use app\components\Helper;
use app\components\Levels;
use app\models\Billing;
use app\models\Booking;
use app\models\Fleet;
use app\models\Flights\Status;
use app\models\Log;
use app\models\Users;
use Yii;
use yii\base\View;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseVarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\DetailView;

use app\models\Flights;
use app\models\Squadrons;

/**
 * FightController implements the CRUD actions for Flights model.
 */
class FlightsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    public function actionSquadron($id)
    {
        return $this->actionIndex(
            null,
            Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $id)->orderBy(
                ['id' => SORT_DESC]
            ),
            false
        );
    }

    /**
     * Lists all Flights models.
     * @return mixed
     */
    public function actionIndex($id = null, $query = null, $partial = false)
    {
        if ($query == null) {
            $query = $id ? Flights::find()->where(['user_id' => $id])->orderBy(['id' => SORT_DESC]) : Flights::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($partial == false) {
            return $this->render(
            'view',
            [
                'user_id' => $id,
                'dataProvider' => $dataProvider,
                'from_view' => false,
                'init' => true
            ]
        );
        } else {
            return $this->renderAjax(
                'view',
                [
                    'user_id' => $id,
                    'dataProvider' => $dataProvider,
                    'from_view' => false
                ]
            );
        }
    }

    /**
     * Displays a single Flights model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $query = Flights::find()->where(['user_id' => $model->user_id])->andWhere(['status' => 2])->orderBy(
            ['id' => SORT_DESC]
        );

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render(
            'view',
            [
                'user_id' => $model->user_id,
                'model' => $model,
                'dataProvider' => $dataProvider,
                'init' => true
            ]
        );
    }

    /**
     * Displays a single Flights model.
     * @param integer $id
     * @return mixed
     */
    public function actionInfo($id)
    {
        $model = $this->findModel($id);
        $suspensions = new ActiveDataProvider([
            'query' => $model->getSuspensions()
        ]);
        return $this->render(
            'info',
            [
                'model' => $model,
                'user_id' => $model->user_id,
                'suspensions' => $suspensions
            ]
        );
    }

    public function actionBriefing()
    {
        $model = Booking::find()->where('status < '.Booking::BOOKING_FLIGHT_END)->andWhere(['user_id' => Yii::$app->user->identity->vid])->one();

        return $this->render(
            'briefing',
            [
                'model' => $model,
                'user_id' => $model->user_id,
            ]
        );
    }

    /**
     * Updates an existing Flights model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update',
                [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionMapdata($id = null)
    {
        echo Flights::prepareTrackerData($id);
    }

    public function actionCurrent($id = null)
    {
        $flight = $this->findModel($id);
        echo json_encode(
            [
                'lat' => $flight->lastTrack->latitude,
                'lon' => $flight->lastTrack->longitude,
                'hdg' => $flight->lastTrack->heading
            ]
        );
    }

    public function actionBooking()
    {
        $data = ['id' => 0];
        $model = Booking::find()->where('status < ' . Booking::BOOKING_FLIGHT_END)->andWhere(['user_id' => Yii::$app->user->identity->vid])->one();

        if ($model->flight) {
            $data['id'] = (int) $model->id;
        }

        return json_encode($data);
    }

    public function actionDetails($id = null)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('details', ['model' => $model]);
    }

    public function actionFix($id)
    {
        if ($flight = $this->findModel($id)) {
            $booking = Booking::find()->andWhere(['id' => $flight->id])->one();

            $flight->landing = $flight->to_icao;
            $flight->finished = gmdate('Y-m-d H:i:s');
            $flight->status = Flights::FLIGHT_STATUS_OK;
            $booking->status = Booking::BOOKING_FLIGHT_END;
            $flight->flight_time = round(Helper::time2seconds($flight->eet) / 60);

            Users::transfer($flight->user_id, $flight->landing);

            if ($booking->fleet_regnum) {
                Fleet::transfer($flight->fleet_regnum, $flight->landing);
                Fleet::changeStatus($booking->fleet_regnum, Fleet::STATUS_AVAIL);
                Fleet::checkSrv($booking->fleet_regnum, $flight->landing);
            }

            $flight->vucs = Billing::calculatePriceForFlight(
                $flight->from_icao,
                $flight->landing,
                unserialize($flight->paxtypes)
            );
            Billing::doFlightCosts($flight);
            Levels::flight($flight->user_id, $flight->nm);
            $booking->save();
            $flight->save();

            Status::get($booking, $flight->landing);


            Log::action(Yii::$app->user->id, 'success', 'flights', $id);

            return $this->redirect(['view', 'id' => $flight->id]);
        }
    }

    /**
     * Finds the Flights model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flights the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flights::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}