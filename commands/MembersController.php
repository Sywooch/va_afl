<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 06.01.16
 * Time: 14:40
 *
 * Запуск из крона каждый час
 *
 */
namespace app\commands;

use Yii;
use yii\console\Controller;

use app\models\Flights;
use app\models\Services\notifications\Notification;
use app\models\UserPilot;

class MembersController extends Controller
{
    public function actionIndex()
    {
        $this->makeActive();
        $this->makeInactive();
    }

    private function makeActive()
    {
        $byFlights = Flights::find()->where('first_seen >= DATE_SUB(NOW(), INTERVAL 90 DAY)')->groupBy('user_id')->all();

        foreach ($byFlights as $flight) {
            if ($flight->user->pilot->status == UserPilot::STATUS_INACTIVE) {
                $flight->user->pilot->status = UserPilot::STATUS_ACTIVE;
                $flight->user->pilot->save();
                Notification::add($flight->user_id, 0, 5013, 'fa-hand-spock-o', 'green');
            }
        }
    }

    private function makeInactive()
    {
        $records = Yii::$app->db->createCommand('SELECT vid FROM users LEFT JOIN (SELECT * FROM flights WHERE first_seen >= DATE_SUB(NOW(), INTERVAL 90 DAY)) a ON users.vid = a.user_id JOIN user_pilot ON users.vid = user_pilot.user_id WHERE user_pilot.status = 1 AND id IS NULL GROUP BY users.vid')->queryAll();

        foreach ($records as $record) {
            $user = UserPilot::findOne(['user_id' => $record['vid']]);
            $user->status = UserPilot::STATUS_INACTIVE;
            $user->save();
            Notification::add($record['vid'], 0, 5013, 'fa-hand-spock-o', 'red');
        }
    }
}