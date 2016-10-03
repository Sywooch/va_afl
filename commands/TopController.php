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

use app\models\Top\PositionSet;
use app\models\Top\Rating;
use app\models\Top\Top;
use app\models\UserPilot;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class TopController extends Controller
{
    public function actionIndex()
    {
        $this->all();
        $this->currentMouth();
    }

    public function actionRecollect(){
        for ($year = 2015; $year <= gmdate("Y"); $year++){
            for($mouth = 1; $mouth <= 12; $mouth++){
                $this->stats($mouth, $year);
                $this->pos($mouth, $year);
                $this->rating($mouth, $year);
                $this->pos($mouth, $year, true);
            }
        }
    }

    private function all()
    {
        $this->stats(0, 0);
        $this->pos(0, 0);
        $this->rating(0, 0);
        $this->pos(0, 0, true);
    }

    private function currentMouth()
    {
        $this->stats(gmdate("m"), gmdate("Y"));
        $this->pos(gmdate("m"), gmdate("Y"));
        $this->rating(gmdate("m"), gmdate("Y"));
        $this->pos(gmdate("m"), gmdate("Y"), true);
    }

    private function stats($mouth, $year)
    {
        $users = ArrayHelper::getColumn(UserPilot::find()->where('experience >= 1')->all(), 'user_id');
        foreach ($users as $user) {
            Top::user($user, $mouth, $year);
        }
    }

    private function rating($mouth, $year)
    {
        new Rating($this->records($mouth, $year), $mouth, $year);
    }

    private function pos($mouth, $year, $rating = false)
    {
        new PositionSet($this->records($mouth, $year), $rating, date("N") == 1 ? true : false);
    }

    private function records($mouth, $year)
    {
        $records = Top::find();

        if ($mouth > 0 && $year > 0) {
            $records->filterWhere(['AND', ['month' => $mouth], ['year' => $year]]);
        }

        return $records;
    }
}