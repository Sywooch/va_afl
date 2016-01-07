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

    public function getFromport()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'from_icao']);
    }

    public static function getPaxListForAirport($icao)
    {
        $data = [];
        foreach (self::find()->select('
        (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end) as waiting_hours,
        sum(num_pax) as num_pax'
        )
                     ->andWhere('from_icao="' . $icao . '"')
                     ->groupBy('
       (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end)')
                     ->orderBy('num_pax desc')->all() as $p) {
            $data[$p['waiting_hours']] = $p['num_pax'];
        }
        return $data;
    }

    public static function getAirportsList()
    {
        $data = [];
        foreach (self::find()->select('from_icao')->distinct(true)->all() as $apt) {
            $data[] = [
                'lat' => $apt->fromport->lat,
                'lon' => $apt->fromport->lon,
                'name' => $apt->from_icao,
                'paxlist' => self::getPaxListForAirport($apt->from_icao)
            ];
        }
        return $data;
    }
}
