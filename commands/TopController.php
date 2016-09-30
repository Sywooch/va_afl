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
            }
        }
    }

    private function all()
    {
        $this->stats(0, 0);
        $this->pos(0, 0);
    }

    private function currentMouth()
    {
        $this->stats(gmdate("m"), gmdate("Y"));
        $this->pos(gmdate("m"), gmdate("Y"));
    }

    private function stats($mouth, $year)
    {
        $users = ArrayHelper::getColumn(UserPilot::find()->where('experience >= 1')->all(), 'user_id');
        foreach ($users as $user) {
            Top::user($user, $mouth, $year);
        }
    }

    private function pos($mouth, $year){
        $records = Top::find();

        if($mouth > 0 && $year > 0){
            $records->filterWhere(['AND', 'mouth' => $mouth, 'year' => $year]);
        }

        new PositionSet($records);
    }
}