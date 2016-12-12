<?php

namespace app\models;

use app\components\Levels;
use app\models\Top\Top;
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
    const STATUS_PENDING = 4;

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
            [['user_id', 'status', 'minutes', 'vk_id', 'level', 'experience', 'avail_booking', 'interface_newyear'], 'integer'],
            [['staff_comments', 'stream_link', 'user_comments', 'staff_comments', 'center_comments'], 'string'],
            [['location'], 'string', 'max' => 4],
            [['avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'location' => Yii::t('user', 'Location'),
            'status' => Yii::t('user', 'Status'),
            'staff_comments' => Yii::t('user', 'Staff Comments'),
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
            self::STATUS_PENDING => Yii::t('user', 'Pending')
        ];
    }

    public function getStatusType()
    {
        return ArrayHelper::getValue(self::getStatusTypesArray(), $this->status);
    }

    public static function getStatusTypesArray()
    {
        return [
            self::STATUS_INACTIVE => 'info',
            self::STATUS_ACTIVE => 'success',
            self::STATUS_SUSPENDED => 'danger',
            self::STATUS_DELETED => 'danger',
            self::STATUS_PENDING => 'warning'
        ];
    }

    public function getBillingUserBalance()
    {
        return $this->hasOne(BillingUserBalance::className(), ['user_vid' => 'user_id']);
    }

    public function getAirport()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'location']);
    }

    public function getTopAll()
    {
        return Top::find()->where(['user_id' => $this->user_id, 'month' => 0, 'year' => 0])->one();
    }

    public function getTopMouth()
    {
        return Top::find()->where(['user_id' => $this->user_id, 'month' => gmdate("m"), 'year' => gmdate("Y")])->one();
    }

    public function getFlights()
    {
        return $this->hasMany(Flights::className(), ['user_id' => 'user_id']);
    }

    public function getStaff()
    {
        return Staff::roles($this->user_id);
    }

    public function getTime()
    {
        /*$query = New Query();
        $query->select('SUM(TIMESTAMPDIFF(SECOND,`dep_time`,`landing_time`)) AS flight_time')->from('flights')->where(
            ['user_id' => $this->user_id]
        );
        $result = $query->one();
        return $result['flight_time'];*/
        return Flights::getTime($this->user_id);
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

    public function getStatFlightsDomestic()
    {
        return Flights::getStatFLightsDomestic($this->user_id);
    }

    public function getUserRoutes()
    {
        return Helper::userRoutes($this->user_id);
    }

    public function getProgress(){
        return Levels::getProgress($this->experience, $this->level);
    }
}
