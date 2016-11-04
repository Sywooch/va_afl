<?php
/**
 * Запуск из крона раз в день
 */
namespace app\commands;

use yii\console\Controller;
use yii\helpers\ArrayHelper;

use app\models\Top\PositionSet;
use app\models\Top\Rating;
use app\models\Top\Top;
use app\models\UserPilot;

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
                $this->process($mouth, $year);
            }
        }
    }

    private function all()
    {
        $this->process(0,0);
    }

    private function currentMouth()
    {
        $this->process(gmdate("m"), gmdate("Y"));
    }
    
    private function process($mouth, $year)
    {
        $this->stats($mouth, $year);
        $this->pos($mouth, $year);
        $this->rating($mouth, $year);
        $this->pos($mouth, $year, true);
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
        new Rating(Top::byMonth($mouth, $year), $mouth, $year);
    }

    private function pos($mouth, $year, $rating = false)
    {
        new PositionSet(Top::byMonth($mouth, $year), $rating, gmdate("N") == 1 ? true : false);
    }
}