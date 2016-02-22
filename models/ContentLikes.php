<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_likes".
 *
 * @property integer $content_id
 * @property integer $user_id
 * @property string $submit
 *
 * @property Content $content
 * @property Users $user
 */
class ContentLikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'user_id'], 'required'],
            [['content_id', 'user_id'], 'integer'],
            [['submit'], 'safe'],
            [['user_id', 'content_id'], 'unique', 'targetAttribute' => ['user_id', 'content_id'], 'message' => 'The combination of Content ID and User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => Yii::t('app', 'Content ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'submit' => Yii::t('app', 'Submit'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }
}
