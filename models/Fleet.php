<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\Json;

/**
 * This is the model class for table "fleet".
 *
 * @property string $regnum
 * @property string $type_code
 * @property string $full_type
 * @property integer $status
 * @property integer $user_id
 * @property string $home_airport
 * @property string $location
 * @property string $image_path
 * @property integer $squadron_id
 * @property integer $max_pax
 * @property integer $max_hrs Налёт до ТО (минуты)
 * @property integer $hrs Налёт после ТО (минуты)
 * @property integer $need_srv Требуется ТО (минуты)
 */
class Fleet extends \yii\db\ActiveRecord
{
    const STATUS_OLD = -1;
    const STATUS_AVAIL = 0;
    const STATUS_LOCKED = 1;
    const STATUS_ENROUTE = 2;

    public static $airports = [
        'A319' => ['UUEE'],
        'A320' => ['UUEE'],
        'A321' => ['UUEE'],
        'A332' => ['UUEE'],
        'A333' => ['UUEE'],
        'B77W' => ['UUEE'],
        'B738' => ['UUEE'],
        'SU95' => ['UUEE']
    ];

    public static function randByType($acftype)
    {
        return Fleet::find()->where(['type_code' => $acftype])->one();
    }

    public static function notInBase()
    {
        return self::find()->where('location != home_airport')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['regnum'], 'required'],
            [['status', 'user_id', 'squadron_id', 'max_pax', 'max_hrs', 'profile', 'hrs', 'need_srv'], 'integer'],
            [['image_path'], 'string'],
            [['regnum', 'type_code'], 'string', 'max' => 10],
            [['full_type'], 'string', 'max' => 100],
            [['home_airport', 'location', 'selcal'], 'string', 'max' => 44]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'regnum' => 'Regnum',
            'type_code' => Yii::t('flights', 'Type Code'),
            'full_type' => Yii::t('flights', 'Full Type'),
            'status' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User ID'),
            'home_airport' => Yii::t('flights', 'Home Airport'),
            'location' => Yii::t('flights', 'Location'),
            'image_path' => 'Image Path',
            'squadron_id' => Yii::t('flights', 'Flight Squadron'),
            'max_pax' => 'Max Pax',
            'max_hrs' => 'Max Hrs',
        ];
    }

    /**
     * Изменение статуса борта
     * @param $id int ID Самолёта из таблицы
     * @param $status int статус из констант
     */
    public static function changeStatus($id, $status)
    {
        $fleet = self::findOne($id);
        $fleet->status = $status;
        $fleet->save();
    }

    /**
     * Добавление часов до ТО
     * @param $id int ID Самолёта из таблицы
     * @param $time int время в минутах
     */
    public static function hrsAdd($id, $time)
    {
        $fleet = self::findOne($id);
        $fleet->hrs += $time;

        if ($fleet->hrs > $fleet->max_hrs) {
            $fleet->need_srv = 1;
        }

        $fleet->save();
    }

    /**
     * Функция проверки ТО
     * @param $id int ID Самолёта из таблицы
     * @param $landing string ICAO код аэродрома
     */
    public static function checkSrv($id, $landing)
    {
        $fleet = self::findOne($id);
        if (isset(self::$airports[$fleet->type_code])) {
            if (in_array($landing, self::$airports[$fleet->type_code])) {
                $fleet->need_srv = 0;
                $fleet->hrs = 0;
            }
            $fleet->save();
        }
    }

    public static function transfer($regnum, $location, $user_id = 0)
    {
        if (!$regnum) {
            return;
        }
        $fleet = self::find()->andWhere(['id' => $regnum])->one();
        $fleet->location = $location;
        $fleet->user_id = ($location == $fleet->home_airport) ? 0 : $user_id;
        $fleet->save();
    }

    public static function getForBooking($q)
    {
        $out = [];
        $d = Fleet::find()->where(['status' => 0])->andFilterWhere(['or', ['user_id' => 0], ['user_id' => Yii::$app->user->identity->vid]])->andWhere(['location' => Users::getAuthUser()->pilot->location]);
        if ($q) {
            $d->andFilterWhere(
                [
                    'or',
                    ['like', 'regnum', $q],
                    ['like', 'type_code', $q],
                    ['like', 'full_type', $q]
                ]
            );
        }

        $squads = ['or'];

        foreach (Squadrons::find()->all() as $squad) {
            if (Yii::$app->user->can("squadrons/{$squad->abbr}/member")) {
                $squads[] = ['=', 'squadron_id', $squad->id];
            }
        }

        if (count($squads) == 1) {
            $out['results'][] = ['id' => '', 'text' => Yii::t('flights', 'No aircraft available to you. Please join to flights squadrons')];
        } else {
            $d->andFilterWhere($squads);
            $d->orderBy(['type_code' => SORT_ASC]);

            foreach ($d->all() as $data) {
                $out['results'][] = ['id' => $data->id, 'text' => $data->type_code . " (" . $data->regnum . ")"];
            }
        }
        return Json::encode($out);
    }

    public function getStatusHTML()
    {
        switch ($this->status) {
            case -1:
                return '<i class="fa fa-calendar"></i> ' . Yii::t('flights', 'In History');
                break;
            case 0:
                return '<i class="fa fa-unlock"></i> ' . Yii::t('flights', 'Available');
                break;
            case 1:
                return '<i class="fa fa-lock"></i> ' . Yii::t('flights', 'Booked');
                break;
            case 2:
                return '<i class="fa fa-plane"></i> ' . Yii::t('flights', 'In flight');
                break;
            default:
                return '<i class="fa fa-lock"></i> ' . Yii::t('flights', 'No info');
        }
    }

    public function getAirportInfo()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'location']);
    }

    public function getHomeAirportInfo()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'home_airport']);
    }

    public function getProfileInfo()
    {
        return $this->hasOne('app\models\FleetProfiles', ['id' => 'profile']);
    }

    public function getLastFlight()
    {
        return Flights::find()->where('fleet_regnum = ' . $this->id)->orderBy(['flights.id' => SORT_DESC])->one();
    }

    public function getLastSuccessFlight()
    {
        return Flights::find()->where('fleet_regnum = ' . $this->id)->andWhere(['status' => Flights::FLIGHT_STATUS_OK])->orderBy(['flights.id' => SORT_DESC])->one();
    }

    public function getActypes(){
        return $this->hasOne('app\models\Actypes', ['code' => 'type_code']);
    }

    public function getName(){
        return $this->regnum.' ('.$this->type_code.')';
    }

    public function getUser(){
        return $this->hasOne('app\models\Users', ['vid' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fleet';
    }
}