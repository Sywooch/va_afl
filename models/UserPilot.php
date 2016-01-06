<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\components\Helper;

/**
 * This is the model class for table "user_pilot".
 *
 * @property integer $user_id
 * @property string $location
 * @property integer $status
 * @property integer $rank_id
 * @property integer $minutes
 * @property string $staff_comments
 */
class UserPilot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;
    const STATUS_DELETED = 3;


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
            [['user_id', 'status', 'rank_id', 'minutes'], 'integer'],
            [['staff_comments'], 'text'],
            [['location'], 'string', 'max' => 4],
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
            'status' => Yii::t('user', 'Status'),
            'rank_id' => 'Rank ID',
            'staff_comments' => Yii::t('user','Staff Comments'),
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('user', 'Inactive'),
            self::STATUS_ACTIVE => Yii::t('user', 'Active'),
            self::STATUS_SUSPENDED => Yii::t('user', 'Suspended'),
            self::STATUS_DELETED => Yii::t('user', 'Deleted'),
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
        return $this->hasMany(Flights::className(), ['user_id' => 'user_id']);
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
        return Flights::getFlightsCount($this->user_id);
    }

    public function getPassengers()
    {
        return Flights::getPassengers($this->user_id);
    }

    public function getMiles()
    {
        return Flights::getMiles($this->user_id);
    }

    public function getStatWeekdays()
    {
        return Flights::getStatWeekdays($this->user_id);
    }

    public function getStatAcfTypes()
    {
        return Flights::getStatAcfTypes($this->user_id);
    }

    public function getUserRoutes()
    {
        return Helper::userRoutes($this->user_id);
    }


}
