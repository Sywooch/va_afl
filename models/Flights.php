<?php

namespace app\models;

use app\components\Helper;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\Airports;
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
            [['user_id', 'booking_id', 'sim', 'pob', 'status', 'nm', 'domestic', 'flight_time'], 'integer'],
            [['first_seen', 'last_seen', 'dep_time', 'eet', 'landing_time', 'fob'], 'safe'],
            [['flightplan', 'remarks'], 'string'],
            [['eet', 'sim', 'nm'], 'required'],
            [['from_icao', 'to_icao', 'alternate1'], 'string', 'max' => 5],
            [['acf_type', 'fleet_regnum', 'callsign'], 'string', 'max' => 10]
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

    public static function getFlightsCount($id)
    {
        return Flights::find()->where(['user_id' => $id])->count();
    }

    public static function getPassengers($id)
    {
        return Flights::find()->where(['user_id' => $id])->sum('pob');
    }

    public static function getMiles($id)
    {
        return Flights::find()->where(['user_id' => $id])->sum('nm');
    }

    public static function getStatWeekdays($id)
    {
        $stats_raw = Flights::find()->where(['user_id' => $id])->select(
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

    public static function getStatAcfTypes($id)
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

    public function getFleet()
    {
        return $this->hasOne(Fleet::className(), ['regnum' => 'fleet_regnum']);
    }
}