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
            'location' => 'Location',
            'active' => 'Active',
            'rank_id' => 'Rank ID',
        ];
    }
    public function getRank()
    {
        return $this->hasOne(Ranks::className(),['id'=>'rank_id']);
    }
}
