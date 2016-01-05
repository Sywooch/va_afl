<?php

namespace app\models;

use Yii;
use yii\db\Query;
use app\models\Flights;
use app\components\Helper;

/**
 * This is the model class for table "user_pilot".
 *
 * @property integer $user_id
 * @property string $location
 * @property integer $active
 * @property integer $rank_id
 */
class UserPilot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_pilot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'active', 'rank_id', 'minutes'], 'integer'],
            [['location'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'location' => Yii::t('app', 'Location'),
            'active' => 'Active',
            'rank_id' => 'Rank ID',
        ];
    }

    public function getRank()
    {
        return $this->hasOne(Ranks::className(), ['id' => 'rank_id']);
    }

    public function getAirport()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'location']);
    }

    public function getFlights()
    {
        return $this->hasMany('app\models\Flights', ['user_id' => 'user_id']);
    }

    public function getTime()
    {
        $query = New Query();
        $query->select('SUM(TIMESTAMPDIFF(SECOND,`dep_time`,`landing_time`)) AS flight_time')->from('flights')->where(['user_id' => $this->user_id]);
        $result = $query->one();
        /*foreach ($this->flights as $flight) {
            $time += strtotime($flight->landing_time) - strtotime($flight->dep_time);
        }*/
        return $result['flight_time'];
    }

    public function getFlightsCount()
    {
        return Flights::find()->where(['user_id' => $this->user_id])->count();
    }

    public function getPassengers()
    {
        return Flights::find()->where(['user_id' => $this->user_id])->sum('pob');
    }

    public function getMiles()
    {
        return Flights::find()->where(['user_id' => $this->user_id])->sum('nm');
    }

    public function getUserRoutes()
    {
        return Helper::userRoutes($this->user_id);
    }


}
