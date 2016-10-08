<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 01.10.2016
 * Time: 1:11
 */

namespace app\models\Top;

use yii\db\ActiveQuery;

class PositionSet
{
    public $fields;
    public $week_diff;
    public $records;

    /**
     * @param ActiveQuery $records
     * @param bool $rating
     * @param bool $week_diff
     */
    public function __construct(ActiveQuery $records, $rating = false, $week_diff = false)
    {
        $this->fields = !$rating ? Top::$count_fields : ['rating_count'];
        $this->week_diff = $week_diff;
        $this->records = $records;
        $this->process();
    }

    private function process(){
        foreach($this->fields as $field){
            $this->field($field);
        }
    }

    /**
     * @param $field
     */
    private function field($field){
        $fieldRecords = $this->records->orderBy($field.' DESC')->all();
        $field = str_replace("count", "pos", $field);

        $i = 1;
        foreach($fieldRecords as $record){
            /**
             * @var Top $record
             */
            if($field == 'rating_pos'){
                $record->rating_pos_change_day = $i - $record->rating_pos;

                if($this->week_diff){
                    $record->rating_pos_change_week = $i - $record->rating_pos_week;
                    $record->rating_pos_week = $i;
                }
            }

            $record->$field = $i;
            $record->save();

            $i++;
        }
    }
}