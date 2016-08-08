<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property string $flight
 * @property string $dep
 * @property string $arr
 * @property string $aircraft
 * @property string $dep_utc_time
 * @property string $arr_utc_time
 * @property string $dep_lmt_time
 * @property string $arr_lmt_time
 * @property string $eet
 * @property string $day of weeks
 * @property string $start
 * @property string $stop
 * @property string $added
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    public static function next($from, $to)
    {
        return self::find()->andWhere(['arr' => $to, 'dep' => $from])
            ->andWhere('SUBSTRING(day_of_weeks,' . date('N') . ',1) = 1')
            ->andWhere('dep_utc_time >= \''.date('H').':00:00\'')
            ->andWhere('start <= \''.date('Y-m-d').'\'')
            ->andWhere('stop >= \''.date('Y-m-d').'\'')
            ->orderBy('dep_utc_time asc')
            ->limit(9);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flight', 'dep', 'arr', 'aircraft', 'dep_utc_time', 'arr_utc_time', 'dep_lmt_time', 'arr_lmt_time', 'eet', 'day_of_weeks', 'start', 'stop'], 'required'],
            [['dep_utc_time', 'arr_utc_time', 'dep_lmt_time', 'arr_lmt_time', 'eet', 'start', 'stop', 'added'], 'safe'],
            [['flight'], 'string', 'max' => 10],
            [['dep', 'arr', 'aircraft'], 'string', 'max' => 4],
            [['day of weeks'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flight' => Yii::t('flights', 'Flight'),
            'dep' => Yii::t('flights', 'Departure'),
            'arr' => Yii::t('flights', 'Arrival'),
            'aircraft' => Yii::t('flights', 'Aircraft'),
            'dep_utc_time' => 'ETD',
            'arr_utc_time' => 'ETA',
            'dep_lmt_time' => 'Dep Lmt Time',
            'arr_lmt_time' => 'Arr Lmt Time',
            'eet' => 'EET',
            'day of weeks' => 'Day Of Weeks',
            'start' => 'Start',
            'stop' => 'Stop',
            'added' => 'Added',
        ];
    }

    public function getDeparture()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'dep']);
    }

    public function getArrival()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'arr']);
    }
}
