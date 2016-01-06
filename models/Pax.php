<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pax".
 *
 * @property integer $id
 * @property string $from_icao
 * @property string $to_icao
 * @property integer $waiting_hours
 * @property integer $num_pax
 */
class Pax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['waiting_hours', 'num_pax'], 'integer'],
            [['from_icao', 'to_icao'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_icao' => 'From Icao',
            'to_icao' => 'To Icao',
            'waiting_hours' => 'Waiting Hours',
            'num_pax' => 'Num Pax',
        ];
    }
}
