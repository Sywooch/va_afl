<?php

namespace app\models\Tours;

use Yii;

/**
 * This is the model class for table "{{%tours_users}}".
 *
 * @property integer $id
 * @property integer $tour_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $legs_finished
 *
 * @property Tours $tour
 * @property Users $user
 */
class ToursUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tours_users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'user_id'], 'required'],
            [['tour_id', 'user_id', 'status', 'legs_finished'], 'integer'],
            [['tour_id', 'user_id'], 'unique', 'targetAttribute' => ['tour_id', 'user_id'], 'message' => 'The combination of Tour ID and User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tour_id' => Yii::t('app', 'Tour ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'legs_finished' => Yii::t('app', 'Legs Finished'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }
}
