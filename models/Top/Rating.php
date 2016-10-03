<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 01.10.2016
 * Time: 18:25
 */

namespace app\models\Top;


use app\models\Suspensions;
use yii\db\ActiveQuery;

class Rating
{
    /**
     * Rating constructor.
     * @param ActiveQuery $records
     * @param $month
     * @param $year
     */
    public function __construct($records, $month, $year)
    {
        /**
         * @var Top $record
         */
        foreach ($records->all() as $record) {
            if ($record->month == 0 && $record->year == 0) {
                $record->rating_type = Top::RATING_ALL;
                $sum = $record->exp_pos + $record->flights_pos + $record->hours_pos + $record->pax_pos;
                $pos = $sum / 4;
            }elseif (($record->month < 9 && $year == 2016) || $year < 2016) {
                $record->rating_type = Top::RATING_OLD;
                $sum = $record->flights_pos + $record->hours_pos;
                $pos = $sum / 2;
            } else {
                $record->rating_type = Top::RATING_NEW;
                $sum = $record->flights_pos + $record->hours_pos + $record->pax_pos;
                $pos = $sum / 3;
            }

            $preRating = $pos + (int)Suspensions::overPeriod($record->user_id, $month, $year)->count();
            if($preRating <= 0){
                $preRating = 999;
            }

            $record->rating_count = round(
                1 / ($preRating) * 100000
            );
            $record->save();
        }
    }
}