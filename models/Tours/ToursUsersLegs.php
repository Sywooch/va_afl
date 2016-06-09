<?php

namespace app\models\Tours;

use Yii;

use app\models\Booking;
use app\models\Users;

/**
 * This is the model class for table "tours_users_legs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tour_id
 * @property integer $flight_id
 * @property integer $status
 *
 * @property Users $user
 * @property Tours $tour
 * @property Booking $flight
 */
class ToursUsersLegs extends \yii\db\ActiveRecord
{
    const STATUS_FLIGHT_STARTED = 0;
    const STATUS_FLIGHT_FINISHED = 1;
    const STATUS_FLIGHT_FAILED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tours_users_legs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tour_id', 'flight_id'], 'required'],
            [['user_id', 'tour_id', 'flight_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'tour_id' => Yii::t('app', 'Tour ID'),
            'flight_id' => Yii::t('app', 'Flight ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourUser()
    {
        return ToursUsers::findOne(['tour_id' => $this->tour_id, 'user_id' => $this->tour_id]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tours::className(), ['id' => 'tour_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Booking::className(), ['id' => 'flight_id']);
    }
}
