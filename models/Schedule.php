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
            'flight' => Yii::t('schedule', 'Flight'),
            'dep' => Yii::t('schedule', 'Departure'),
            'arr' => Yii::t('schedule', 'Arrival'),
            'aircraft' => Yii::t('schedule', 'Aircraft'),
            'dep_utc_time' => Yii::t('schedule', 'ETD'),
            'arr_utc_time' => Yii::t('schedule', 'ETA'),
            'dep_lmt_time' => 'Dep Lmt Time',
            'arr_lmt_time' => 'Arr Lmt Time',
            'eet' => 'Eet',
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
