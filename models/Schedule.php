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
     * Следующие рейсы до конца текущих суток и на следующие сутки
     * @param $from string ICAO Code
     * @param $to string ICAO Code
     * @param $limit int count of flights
     * @return $this
     */
    public static function next($from, $to, $limit = 6)
    {
        return self::find()->andWhere(['arr' => $to, 'dep' => $from])
            ->andWhere('SUBSTRING(day_of_weeks,' . gmdate('N') . ',1) = 1')
            ->andFilterWhere(['or', 'dep_utc_time >= \'' . gmdate('H') . ':00:00\'', 'dep_utc_time >= \'00:00:00\''])
            ->andFilterWhere(['and', 'start <= \'' . gmdate('Y-m-d') . '\'', 'stop >= \'' . gmdate('Y-m-d') . '\''])
            ->orderBy('dep_utc_time asc')
            ->limit($limit);
    }

    /**
     * Возможжно не генерит паксов из-за gmdate('H:i:s', strtotime('+1 hour')) с 00:00 до 01:00 (25 часов?)
     */
    public static function inHour($withoutAll = false)
    {
       $data = self::find()
            ->andWhere('dep_utc_time > "' . gmdate('H:i:s') . '"')
            ->andWhere('dep_utc_time < "' . gmdate('H:i:s', strtotime('+1 hour')) . '"')
            ->andWhere('SUBSTRING(day_of_weeks,' . gmdate('N') . ',1) = 1')
            ->andWhere('start <="' . gmdate('Y-m-d') . '"')
            ->andWhere('stop >= "' . gmdate('Y-m-d') . '"')
            ->orderBy('dep_utc_time');

        return $withoutAll ? $data : $data->all();
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
