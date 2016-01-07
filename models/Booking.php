<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booking".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $from_icao
 * @property string $to_icao
 * @property string $callsign
 * @property string $aircraft_type
 * @property string $fleet_regnum
 * @property integer $schedule_id
 * @property string $non_schedule_utc
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'schedule_id', 'status'], 'integer'],
            [['non_schedule_utc', 'status'], 'safe'],
            [['from_icao', 'to_icao'], 'string', 'max' => 5],
            [['callsign', 'aircraft_type', 'fleet_regnum'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'from_icao' => Yii::t('flights', 'Departure airport'),
            'to_icao' => Yii::t('flights', 'Arrival Airport'),
            'callsign' => Yii::t('flights', 'Callsign'),
            'aircraft_type' => Yii::t('flights', 'Aircraft Type'),
            'fleet_regnum' => Yii::t('flights', 'Aircraft Registration Number'),
            'schedule_id' => Yii::t('boking', 'Flight number'),
            'non_schedule_utc' => Yii::t('flights', 'UTC departure time'),
        ];
    }

    public function addData()
    {
        $userdata = Users::getAuthUser();
        $this->from_icao = $userdata->pilot->location;
        $this->user_id = $userdata->vid;
    }

    public function getFlight()
    {
        return $this->hasOne(Flights::className(), ['booking_id' => 'id']);
    }

    public function getDeparture()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'from_icao']);
    }

    public function getArrival()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'to_icao']);
    }
}
