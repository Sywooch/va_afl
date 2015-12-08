<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flights".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $booking_id
 * @property string $first_seen
 * @property string $lastseen
 * @property string $from_icao
 * @property string $to_icao
 * @property string $flightplan
 * @property integer $fob
 * @property integer $pob
 * @property string $acf_type
 * @property string $fleet_regnum
 * @property integer $status
 */
class Flights extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'booking_id', 'fob', 'pob', 'status'], 'integer'],
            [['first_seen', 'lastseen'], 'safe'],
            [['flightplan'], 'string'],
            [['from_icao', 'to_icao'], 'string', 'max' => 5],
            [['acf_type', 'fleet_regnum'], 'string', 'max' => 10]
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
            'booking_id' => 'Booking ID',
            'first_seen' => 'First Seen',
            'lastseen' => 'Lastseen',
            'from_icao' => 'From Icao',
            'to_icao' => 'To Icao',
            'flightplan' => 'Flightplan',
            'fob' => 'Fob',
            'pob' => 'Pob',
            'acf_type' => 'Acf Type',
            'fleet_regnum' => 'Fleet Regnum',
            'status' => 'Status',
        ];
    }
}
