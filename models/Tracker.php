<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tracker".
 *
 * @property integer $id
 * @property integer $user_id
 * @property double $latitude
 * @property double $longitude
 * @property string $dtime
 * @property integer $heading
 * @property integer $altitude
 * @property integer $groundspeed
 * @property integer $flight_id
 */
class Tracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tracker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'heading', 'altitude', 'groundspeed', 'flight_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['dtime'], 'safe']
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
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'dtime' => 'Dtime',
            'heading' => 'Heading',
            'altitude' => 'Altitude',
            'groundspeed' => 'Groundspeed',
            'flight_id' => 'Flight ID',
        ];
    }
}
