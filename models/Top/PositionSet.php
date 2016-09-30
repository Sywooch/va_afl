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
     */
    public function __construct(ActiveQuery $records)
    {
        foreach(Top::$count_fields as $field){
            $this->field($records, $field);
        }
    }

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