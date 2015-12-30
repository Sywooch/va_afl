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
            [['non_schedule_utc','status'], 'safe'],
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
            'from_icao' => 'From Icao',
            'to_icao' => 'To Icao',
            'callsign' => 'Callsign',
            'aircraft_type' => 'Aircraft Type',
            'fleet_regnum' => 'Fleet Regnum',
            'schedule_id' => 'Schedule ID',
            'non_schedule_utc' => 'Non Schedule Utc',
        ];
    }

    public function addData()
    {
        $userdata = Users::getAuthUser();
        $this->from_icao = $userdata->pilot->location;
        $this->user_id = $userdata->vid;
    }
}
