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

use app\models\Staff\StaffSups;
use app\models\Users;
use app\modules\airline\models\Sup;
use Yii;
use yii\console\Controller;

use app\models\Flights;
use app\models\Services\notifications\actions\Members;
use app\models\UserPilot;

class MembersController extends Controller
{
    public function actionIndex()
    {
        $this->makeActive();
        $this->makeInactive();
        $this->supList();
    }

    private function makeActive()
    {
        $byFlights = Flights::find()->where('first_seen >= DATE_SUB(NOW(), INTERVAL 90 DAY)')->groupBy('user_id')->all();

        foreach ($byFlights as $flight) {
            if ($flight->user->pilot->status == UserPilot::STATUS_INACTIVE) {
                $flight->user->pilot->status = UserPilot::STATUS_ACTIVE;
                $flight->user->pilot->save();
                Members::active($flight->user);
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
            Members::inactive(Users::findOne(['vid' => $user->user_id]));
        }
    }

    private function supList()
    {
        $sups = Sup::active(true);
        StaffSups::clear();
        StaffSups::write($sups);
    }
}