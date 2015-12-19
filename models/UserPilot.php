<?php

namespace app\models;

use Yii;

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
            [['user_id', 'active', 'rank_id'], 'integer'],
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
            'location' => Yii::t('app','Location'),
            'active' => 'Active',
            'rank_id' => 'Rank ID',
        ];
    }
    public function getRank()
    {
        return $this->hasOne(Ranks::className(),['id'=>'rank_id']);
    }
    public function getAirport()
    {
        return $this->hasOne(Airports::className(),['icao'=>'location']);
    }
    public function getFlights()
    {
        return $this->hasMany('app\models\Flights', ['user_id'=>'user_id']);
    }
    public function getHours()
    {
        $time = 0;
        foreach($this->flights as $flight)
        {
            $time += strtotime($flight->landing_time) - strtotime($flight->dep_time);
        }
        $seconds = $time % 60;
        $time = ($time - $seconds) / 60;
        $minutes = $time % 60;
        $hours = ($time - $minutes) / 60;
        return $hours.' '.Yii::t('user','Hours').' '.$minutes.' '.Yii::t('user','Minutes');
    }

}
