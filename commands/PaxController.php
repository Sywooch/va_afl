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
            if($pax->waiting_hours>72)
                $pax->delete();
        }
    }

    private function generatePaxes()
    {
        $data = Schedule::find()
            ->andWhere('dep_utc_time > "'.gmdate('H:i:s').'"')
            ->andWhere('dep_utc_time < "'.gmdate('H:i:s',strtotime('+1 hour')).'"')
            ->andWhere('SUBSTRING(day_of_weeks,'.(gmdate('N')-1).',1) = 1')
            ->andWhere('start < "'.gmdate('Y-m-d').'"')
            ->andWhere('stop > "'.gmdate('Y-m-d').'"')
            ->orderBy('dep_utc_time')->all();
        foreach($data as $paxdata)
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
        $acf = Actypes::find()->andWhere(['code'=>$acftype])->one();
        $maxpax = ($acf)?$acf->max_pax:100; //default value
        return $maxpax;
    }
}