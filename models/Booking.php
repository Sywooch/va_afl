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
            [['user_id','to_icao','from_icao','callsign','fleet_regnum'],'required'],
            [['user_id', 'schedule_id', 'status'], 'integer'],
            [['non_schedule_utc', 'status'], 'safe'],
            [['from_icao', 'to_icao'], 'string', 'max' => 5],
            [['callsign', 'fleet_regnum'], 'string', 'max' => 10]
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
        return $this->hasOne(Fleet::className(),['id'=>'fleet_regnum']);
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

    private static function generateCallsign($from,$to)
    {
        if($sched = Schedule::find()->andWhere(['arr'=>$from])->andWhere(['dep'=>$to])->andWhere('SUBSTRING(day_of_weeks,'.(date('N')-1).',1) = 1')->one())
            return $sched->flight;
        else{
            $namelist=['AFL','TSO'];
            $calsign=$namelist[rand(0,sizeof($namelist)-1)];
            $numbers = "";
            for($num=0;$num<rand(3,4);$num++)
            {
                $numbers .= rand(0,9);
            }

            //Позывной может сгенерироваться полностью нулевым, поэтому меняем цифры принудительно.
            if($numbers == "000") {
                $numbers = "001";
            } elseif($numbers == "0000") {
                $numbers = "0001";
            }

            $calsign .= $numbers;

            return $calsign;
        }
    }

    public static function smartBooking($icao)
    {
        $data=[];
        $apt = Airports::find()->andWhere(['icao'=>$icao])->one();
        $user = Users::getAuthUser();
        $data['callsign']=self::generateCallsign($user->pilot->location,$icao);
        $data['aname']=$apt->name;
        return $data;
    }
    public static function jsonMapData()
    {
        $booking = self::find()->andWhere(['user_id'=>Users::getAuthUser()->vid])->one();
        $data = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type'=>'Feature',
                    'properties'=>[
                        'type'=>'departure',
                        'name'=>$booking->from_icao,
                    ],
                    'geometry'=>[
                        'type'=>'point',
                        'coordinates' => [$booking->departure->lon, $booking->departure->lat],
                    ]
                ],
                [
                    'type'=>'Feature',
                    'properties'=>[
                        'type'=>'arrival',
                        'name'=>$booking->to_icao
                    ],
                    'geometry'=>[
                        'type'=>'point',
                        'coordinates' => [$booking->arrival->lon, $booking->arrival->lat],
                    ]
                ],
                [
                    'type'=>'Feature',
                    'properties'=>[

                    ],
                    'geometry'=>[
                        'type'=>'LineString',
                        'coordinates' => [[$booking->departure->lon, $booking->departure->lat],[$booking->arrival->lon, $booking->arrival->lat]],
                    ]
                ],
            ]
        ];
        return json_encode($data);
    }
}
