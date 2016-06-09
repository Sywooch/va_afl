<?php

namespace app\modules\tours\controllers;

use Yii;
use yii\web\Controller;

use app\models\Tours\Tours;
use app\models\Tours\ToursUsers;


class DefaultController extends Controller
{
    public static $tour;

    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'tours' => Tours::find()->where(['status' => Tours::STATUS_ACTIVE])->all()
            ]
        );
    }

    public function actionView($id)
    {
        self::$tour = Tours::findOne($id);
        return $this->render(
            'view',
            [
                'tour' => self::$tour,
            ]
        );
    }

    public function actionAssign()
    {
        $act = \Yii::$app->request->post('act');
        $tour_id = \Yii::$app->request->post('tour_id');


        $tourUsers = ToursUsers::findOne(['user_id' => \Yii::$app->user->id, 'tour_id' => $tour_id]);

        if ($act == 0) {
            if (!$tourUsers) {
                $tourUsers = new ToursUsers();
                $tourUsers->tour_id = $tour_id;
                $tourUsers->user_id = Yii::$app->user->id;
            }

            $tourUsers->status = ToursUsers::STATUS_ASSIGNED;
        } else {
            $tourUsers->status = ToursUsers::STATUS_UNASSIGNED;
        }

        $tourUsers->save();
    }
}
