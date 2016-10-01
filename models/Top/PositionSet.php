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
    /**
     * @param ActiveQuery $records
     * @param bool $rating
     */
    public function __construct(ActiveQuery $records, $rating = false)
    {
        $fields = !$rating ? Top::$count_fields : ['rating_count'];

        foreach($fields as $field){
            $this->field($records, $field);
        }
    }

    /**
     * @param ActiveQuery $records
     * @param $field
     */
    private function field($records, $field){
        $fieldRecords = $records->orderBy($field.' DESC')->all();

        $i = 1;
        foreach($fieldRecords as $record){
            $field = str_replace("count", "pos", $field);
            $record->$field = $i;
            $i++;
            $record->save();
        }
    }
}