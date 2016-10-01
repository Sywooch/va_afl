<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 01.10.2016
 * Time: 0:22
 */

namespace app\models\Top;


use app\models\Flights;
use Yii;
use yii\base\Component;

class StatsCollector extends Component
{
    private $record;
    private $flights;

    public function __construct(Top $record)
    {
        $this->record = $record;
        $this->flights = Flights::find()->where(['user_id' => $this->record->user_id]);

        if ($this->record->mouth > 0 && $this->record->year > 0) {
            $this->flights->andFilterWhere([
                'AND',
                "first_seen >= '{$this->record->year}-{$this->record->mouth}-01 00:00:00'",
                "first_seen <= '{$this->record->year}-{$this->record->mouth}-31 23:59:59'"
            ]);
        }
    }

    public function getExp_count()
    {
        return $this->record->year == 0 && $this->record->mouth == 0 ? $this->record->user->pilot->experience : 0;
    }

    public function getFlights_count()
    {
        return $this->flights->count();
    }


    public function getHours_count()
    {
        return (int)round($this->flights->sum('flight_time') / 60);
    }

    public function getPax_count()
    {
        return (int)$this->flights->sum('pob');
    }
}