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
 * @property integer $max_hrs
 */
class Fleet extends \yii\db\ActiveRecord
{
    public static function transfer($regnum, $location)
    {
        if (!$regnum) {
            return;
        }
        $fleet = self::find()->andWhere(['id' => $regnum])->one();
        $fleet->location = $location;
        $fleet->save();
    }

    public static function getForBooking($q)
    {
        $out = [];
        $d=Fleet::find()->andWhere(['location' => Users::getAuthUser()->pilot->location]);
        if($q) {
            $d->andFilterWhere(
                [
                    'or',
                    ['like', 'regnum', $q ],
                    ['like', 'type_code', $q],
                    ['like', 'full_type', $q]
                ]
            );
        }

        foreach ($d->all() as $data) {
            $out['results'][] = ['id' => $data->id, 'text' => $data->regnum." (".$data->type_code.")"];
        }
        return Json::encode($out);
    }

    public function getAirportInfo()
    {
        return $this->hasOne('app\models\Airports', ['icao' => 'location']);
    }

    public function getProfileInfo()
    {
        return $this->hasOne('app\models\FleetProfiles', ['id' => 'profile']);
    }

    public function getLastFlight()
    {
        return Flights::find()->where('fleet_regnum = ' . $this->id)->orderBy(['flights.id' => SORT_DESC])->one();
    }

    public function getActypes(){
        return $this->hasOne('app\models\Actypes', ['code' => 'type_code']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fleet';
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
            'type_code' => 'Type Code',
            'full_type' => 'Full Type',
            'status' => 'Status',
            'user_id' => 'User ID',
            'home_airport' => 'Home Airport',
            'location' => 'Location',
            'image_path' => 'Image Path',
            'squadron_id' => 'Squadron ID',
            'max_pax' => 'Max Pax',
            'max_hrs' => 'Max Hrs',
        ];
    }
}