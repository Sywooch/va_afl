<?php

namespace app\models;

use Yii;
use yii\db\Expression;

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
    const BOOKING_INIT = 1;
    const BOOKING_FLIGHT_START = 2;
    const BOOKING_FLIGHT_END = 3;
    const BOOKING_DELETED_BY_USER = 10;

    const STATUS_BOOKED = 0;
    const STATUS_CANCELED = 8;
    const STATUS_CANCELED_BY_COMPANY = 9;
    const STATUS_BOARDING = 10;
    const STATUS_DEPARTING = 11;
    const STATUS_ENROUTE = 15;
    const STATUS_LOSS = 16;
    const STATUS_APPROACH = 20;
    const STATUS_LANDED = 25;
    const STATUS_ON_BLOCKS = 29;
    const STATUS_ARRIVED = 30;
    const STATUS_RETURNED = 31;
    const STATUS_RETURNED_TO_TALT = 32;
    const STATUS_RETURNED_TO_ALT = 33;
    const STATUS_RETURNED_TO_RALT = 34;
    const STATUS_FAILED = 50;

    public function getStatusName()
    {
        if ($this->g_status >= self::STATUS_BOARDING && $this->g_status <= self::STATUS_ON_BLOCKS) {
            return Yii::t('flights', 'In flight');
        }

        switch ($this->g_status) {
            case self::STATUS_ARRIVED:
                return Yii::t('flights', 'Arrived');
                break;
            case self::STATUS_RETURNED:
                return Yii::t('flights', 'Returned');
                break;
            case self::STATUS_RETURNED_TO_TALT:
                return Yii::t('flights', 'Returned to takeoff alternative airport');
                break;
            case self::STATUS_RETURNED_TO_ALT:
                return Yii::t('flights', 'Returned to alternative airport');
                break;
            case self::STATUS_RETURNED_TO_RALT:
                return Yii::t('flights', 'Landed in en-route alternative');
                break;
            case self::STATUS_FAILED:
                return Yii::t('flights', 'Failed');
                break;
            default:
                return Yii::t('flights', 'Unknown');
        }
    }

    public function getStatusColor()
    {
        if ($this->g_status >= self::STATUS_BOARDING && $this->g_status <= self::STATUS_ON_BLOCKS) {
            return 'info';
        }

        switch ($this->g_status) {
            case self::STATUS_ARRIVED:
                return 'success';
                break;
            case self::STATUS_RETURNED:
            case self::STATUS_RETURNED_TO_TALT:
            case self::STATUS_RETURNED_TO_ALT:
            case self::STATUS_RETURNED_TO_RALT:
                return 'warning';
                break;
            case self::STATUS_FAILED:
            default:
                return 'danger';
                break;
        }
    }

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
            [['user_id', 'to_icao', 'from_icao', 'callsign', 'fleet_regnum'], 'required'],
            [['user_id', 'schedule_id', 'status', 'fleet_regnum', 'stream', 'g_status'], 'integer'],
            [['non_schedule_utc', 'status'], 'safe'],
            [['from_icao', 'to_icao'], 'string', 'max' => 5],
            [['callsign'], 'string', 'max' => 10]
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
            'from_icao' => Yii::t('flights', 'Departure Airport'),
            'to_icao' => Yii::t('flights', 'Arrival Airport'),
            'callsign' => Yii::t('flights', 'Callsign'),
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

    public function getFleet()
    {
        return $this->hasOne(Fleet::className(), ['id' => 'fleet_regnum']);
    }

    public function getFlight()
    {
        return $this->hasOne(Flights::className(), ['id' => 'id']);
    }

    public function getDeparture()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'from_icao']);
    }

    public function getArrival()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'to_icao']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }

    private static function generateCallsign($from, $to)
    {
        if ($sched = Schedule::find()->andWhere(['arr' => $from])
            ->andWhere(['dep' => $to])
            ->andWhere('SUBSTRING(day_of_weeks,' . (date('N') - 1) . ',1) = 1')->one()
        ) {
            return $sched->flight;
        } else {
            //$namelist=['AFL','TSO'];
            //$namelist=['AFL','TSO'];

            $airline = "AFL";
            $numbers = "";
            for ($num = 0; $num < rand(3, 4); $num++) {
                $numbers .= rand(0, 9);
            }

            $calsign = "";

            /*if($airline == "AFL")
            {*/
            if ($numbers == "000" or $numbers == "0000") {
                $numbers = "001";
            }

            if (strlen($numbers) == 4) {
                if (substr($numbers, 0, 1) == "0") {
                    $numbers = substr($numbers, 1);
                }
            }
            //}

            /*
            if($airline == "TSO")
            {
                if(strlen($numbers) == 3)
                {
                    if(substr($numbers, 0, 1) == "0")
                    {
                        $numbers = substr($numbers, 1);
                        if(substr($numbers, 0, 1) == "0")
                        {
                            $numbers = substr($numbers, 1);
                            if($numbers == "0")
                            {
                                $numbers = rand(1,9);
                            }
                        }
                    }
                }

                if(strlen($numbers) == 4)
                {
                    if(substr($numbers, 0, 1) == "0")
                    {
                        $numbers = substr($numbers, 1);
                        if(substr($numbers, 0, 1) == "0")
                        {
                            $numbers = substr($numbers, 1);
                            if(substr($numbers, 0, 1) == "0")
                            {
                                $numbers = substr($numbers, 1);
                                if($numbers == "0")
                                {
                                    $numbers = rand(1,9);
                                }
                            }
                        }
                    }
                }
            }*/

            $calsign .= $airline . $numbers;

            return $calsign;
        }
    }

    public static function smartBooking($icao)
    {
        $data = [];
        $apt = Airports::find()->andWhere(['icao' => $icao])->one();
        $user = Users::getAuthUser();
        $data['callsign'] = self::generateCallsign($user->pilot->location, $icao);
        $data['aname'] = $apt->name;
        return $data;
    }

    public static function jsonMapData()
    {
        $booking = self::find()->andWhere(['user_id' => Users::getAuthUser()->vid])->andWhere(
            'status < ' . self::BOOKING_FLIGHT_END
        )->one();
        $data = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'properties' => [
                        'type' => 'start',
                        'name' => $booking->from_icao,
                        'title' => $booking->from_icao
                    ],
                    'geometry' => [
                        'type' => 'point',
                        'coordinates' => [$booking->departure->lon, $booking->departure->lat],
                    ]
                ],
                [
                    'type' => 'Feature',
                    'properties' => [
                        'type' => 'stop',
                        'name' => $booking->to_icao,
                        'title' => $booking->to_icao
                    ],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [$booking->arrival->lon, $booking->arrival->lat],
                    ]
                ],
                [
                    'type' => 'Feature',
                    'properties' => [

                    ],
                    'geometry' => [
                        'type' => 'LineString',
                        'coordinates' => [
                            [$booking->departure->lon, $booking->departure->lat],
                            [$booking->arrival->lon, $booking->arrival->lat]
                        ],
                    ]
                ],
            ]
        ];
        return json_encode($data);
    }
}
