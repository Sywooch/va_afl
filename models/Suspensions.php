<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%suspensions}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $issue_user
 * @property string $issue_datetime
 * @property integer $flight_id
 * @property integer $content_id
 *
 * @property Booking $flight
 * @property Content $content
 */
class Suspensions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suspensions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'issue_datetime', 'content_id'], 'required'],
            [['user_id', 'issue_user', 'flight_id', 'content_id'], 'integer'],
            [['issue_datetime'], 'safe']
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
            'issue_user' => Yii::t('app', 'Issue User'),
            'issue_datetime' => Yii::t('app', 'Issue Datetime'),
            'flight_id' => Yii::t('app', 'Flight ID'),
            'content_id' => Yii::t('app', 'Content ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Booking::className(), ['id' => 'flight_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
