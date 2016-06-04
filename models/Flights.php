<?php

namespace app\models;

use app\components\Helper;
use app\models\Flights\Simulator;
use Yii;
use yii\data\ActiveDataProvider;
use yii\i18n\Formatter;

/**
 * This is the model class for table "flights".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $booking_id
 * @property string $first_seen
 * @property string $last_seen
 * @property string $from_icao
 * @property string $to_icao
 * @property string $flightplan
 * @property string $remarks
 * @property string $dep_time
 * @property string $eet
 * @property string $landing_time
 * @property integer $sim
 * @property string $fob
 * @property string $lastseen
 * @property string $acf_type
 * @property string $fleet_regnum
 * @property integer $status
 * @property string $alternate1
 */
class Flights extends \yii\db\ActiveRecord
{
    const FLIGHT_STATUS_OK = 2;
    const FLIGHT_STATUS_BREAK = 3;
    const FLIGHT_STATUS_STARTED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flights';
    }

    public static function countOnline()
    {
        return self::find()->where(['status' => self::FLIGHT_STATUS_STARTED])->count();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sim', 'pob', 'status', 'nm', 'domestic', 'flight_time', 'fleet_regnum'],'integer'],
            [['first_seen', 'last_seen', 'dep_time', 'eet', 'landing_time', 'fob', 'vucs', 'finished'], 'safe'],
            [['flightplan', 'remarks', 'fpl', 'metar_dep', 'metar_landing'], 'string'],
            [['from_icao', 'to_icao', 'alternate1', 'alternate2', 'landing'], 'string', 'max' => 4],
            [['acf_type', 'callsign'], 'string', 'max' => 10]
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
            'callsign' => Yii::t('flights', 'Callsign'),
            'first_seen' => 'First Seen',
            'last_seen' => 'Last Seen',
            'from_icao' => Yii::t('flights', 'Departure Airport'),
            'to_icao' => Yii::t('flights', 'Arrival Airport'),
            'flightplan' => Yii::t('flights', 'Flightplan'),
            'remarks' => 'Remarks',
            'dep_time' => 'Dep Time',
            'eet' => 'Eet',
            'landing_time' => 'Landing Time',
            'sim' => 'Sim',
            'fob' => 'Fob',
            'pob' => 'Pob',
            'acf_type' => Yii::t('flights', 'Acf Type'),
            'fleet_regnum' => 'Fleet Regnum',
            'status' => 'Status',
            'alternate1' => 'Alternate1',
        ];
    }

    public $day;
    public $count;

    public static function getFlightsCount($id)//TODO: перенести в UserPilot
    {
        return Flights::find()->where(['user_id' => $id])->count();
    }

    public static function getPassengers($id)//TODO: перенести в UserPilot
    {
        return Flights::find()->where(['user_id' => $id])->sum('pob');
    }

    public static function getMiles($id)//TODO: перенести в UserPilot
    {
        return Flights::find()->where(['user_id' => $id])->sum('nm');
    }

    public static function getTime($id)//TODO: перенести в UserPilot
    {
        return Flights::find()->where(['user_id' => $id])->sum('flight_time');
    }

    public static function getStatFLightsDomestic($id)//TODO: перенести в UserPilot
    {
        $stats_raw = Flights::find()->where(['user_id' => $id])->select(
            'domestic,COUNT(*) AS `count`'
        )
            ->groupBy(
                [
                    'domestic',
                ]
            )->all();
        $stat = [];
        foreach ($stats_raw as $stat_raw) {
            $stat[] = [
                'name' => $stat_raw->domestic == '1' ? Yii::t('flights', 'Domestic') : Yii::t('flights', 'International'),
                'y' => intval($stat_raw->count)
            ];
        }
        return $stat;
    }

    public static function getStatWeekdays($id)//TODO: перенести в UserPilot
    {
        $stats_raw = Flights::find()->where(['user_id' => $id])->andWhere('WEEKDAY(dep_time) IS NOT NULL')->select(
            'WEEKDAY(dep_time) AS `day`,COUNT(*) AS `count`'
        )
            ->groupBy(
                [
                    'WEEKDAY(dep_time)',
                ]
            )->all();
        $stat = [];
        foreach ($stats_raw as $stat_raw) {
            $stat[] = [
                'name' => Yii::t('time', Helper::getWeekDayFromNumber($stat_raw->day)),
                'y' => intval($stat_raw->count)
            ];
        }
        return $stat;
    }

    public static function getStatAcfTypes($id)//TODO: перенести в UserPilot
    {
        $stats_raw = Flights::find()->where(['user_id' => $id])->select('acf_type,COUNT(*) AS `count`')
            ->groupBy(
                [
                    'acf_type',
                ]
            )->all();
        $stat = [];
        foreach ($stats_raw as $stat_raw) {
            $stat[] = ['name' => $stat_raw->acf_type, 'y' => intval($stat_raw->count)];
        }
        return $stat;
    }


    public function getDepAirport()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'from_icao']);
    }

    public function getArrAirport()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'to_icao']);
    }

    public function getLandingAirport()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'landing']);
    }

    public function getFleet()
    {
        return $this->hasOne(Fleet::className(), ['id' => 'fleet_regnum']);
    }

    public function getTrack()
    {
        return $this->hasMany(Tracker::className(), ['flight_id' => 'id']);
    }

    public function getLastTrack()
    {
        return Tracker::find()->where(['flight_id' => $this->id])->orderBy('id desc')->one();
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }

    public function getBooking()
    {
        return $this->hasOne(Booking::className(), ['id' => 'id']);
    }

    public function getSuspensions()
    {
        return $this->hasOne(Suspensions::className(), ['flight_id' => 'id']);
    }

    public function getSimulator(){
        return Simulator::$ivao[$this->sim];
    }

    public static function prepareTrackerData($id)
    {
        $flightpath = [];
        $colors = [
            0 => '#ffe700',
            2000 => '#ffe700',
            3000 => '#D3FF00',
            6000 => '#00FF00',
            12000 => '#0000FF',
            18000 => '#3D00FF',
            24000 => '#FF2EC5',
            32000 => '#FF0033'
        ];
        $model = self::findOne($id);
        foreach ($model->track as $item) {
            $color = $colors[0];
            foreach ($colors as $alt => $colorset) {
                if ($item->altitude > $alt) {
                    $color = $colorset;
                }
            }
            $flightpath[] = ['color' => $color, 'crd' => [$item->longitude, $item->latitude]];
        }
        $flightpath[] = [
            'color' => 'transparent',
            'crd' => $flightpath[sizeof($flightpath) - 1]['crd']
        ]; //чтобы отработать конец трека
        $data = [
            'type' => 'FeatureCollection'
        ];

        $prevcolor = $colors[0];
        $fpcoords = [];
        foreach ($flightpath as $fppeace) {
            if ($fppeace['color'] != $prevcolor) {
                $data['features'][] = [
                    'type' => 'Feature',
                    'properties' => [
                        'color' => $prevcolor,
                    ],
                    'geometry' => [
                        'type' => 'LineString',
                        'coordinates' => $fpcoords
                    ]
                ];
                $fpcoords = (!empty($fpcoords)) ? [$fpcoords[sizeof($fpcoords) - 1]] : [];
                $prevcolor = $fppeace['color'];
            }
            $fpcoords[] = $fppeace['crd'];
        }

        $data['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'type' => 'start',
                'title' => $model->depAirport->name . ' (' . $model->depAirport->icao . ')'
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$model->depAirport->lon, $model->depAirport->lat]
            ],

        ];

        $data['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'type' => 'stop',
                'title' => $model->arrAirport->name . ' (' . $model->arrAirport->icao . ')'
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$model->arrAirport->lon, $model->arrAirport->lat]
            ],
        ];

        return json_encode($data);
    }

}