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

use app\models\Actypes;
use app\models\BillingUserBalance;
use app\models\Fleet;
use app\models\Pax;
use app\models\Schedule;
use yii\console\Controller;

class PaxController extends Controller
{
    public function actionIndex()
    {
        $this->hoursUp();
        $this->generatePaxes();
    }

    private function hoursUp()
    {
        foreach (Pax::find()->all() as $pax)
        {
            $pax->waiting_hours+=1;
            $pax->save();
            if($pax->waiting_hours>72) {
                //Списать вуки со счета компании
                $ub = BillingUserBalance::find()->andWhere(['user_vid'=>0])->one();
                if(!$ub) {
                    $ub = new BillingUserBalance();
                    $ub->user_vid = 0;
                }
                $ub->balance-=$pax->num_pax*2;
                $ub->save();
                $pax->delete();
            }
        }
    }

    private function generatePaxes()
    {
        foreach(Schedule::inHour() as $paxdata)
        {
            if(Pax::find()->andWhere('from_icao="'.$paxdata->dep.'"')->andWhere('waiting_hours>=24')->one())
                continue;
            if(!$pax=Pax::find()->andWhere('from_icao="'.$paxdata->dep.'"')->andWhere('to_icao="'.$paxdata->arr.'"')->andWhere('waiting_hours=0')->one())
                $pax = new Pax();
            $pax->from_icao = $paxdata->dep;
            $pax->to_icao = $paxdata->arr;
            $pax->waiting_hours = 0;
            $pax->num_pax += $this->generateRandomPaxes($paxdata->aircraft);
            $pax->save();
        }
    }
    private function generateRandomPaxes($acftype)
    {
        $acf = Fleet::randByType($acftype);
        return ($acf ? ($acf->max_pax > 0 ? $acf->max_pax : 100) : 101);
    }
}