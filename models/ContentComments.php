<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_comments".
 *
 * @property integer $content_id
 * @property integer $user_id
 * @property string $write
 * @property string $text
 *
 * @property Content $content
 * @property Users $user
 */
class ContentComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'user_id', 'id'], 'integer'],
            [['write'], 'safe'],
            [['text'], 'required'],
            [['text'], 'string', 'max' => 250],
            [['content_id', 'user_id', 'write'], 'unique', 'targetAttribute' => ['content_id', 'user_id', 'write'], 'message' => 'The combination of Content ID, User ID and Write has already been taken.']
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
            'write' => Yii::t('app', 'Write'),
            'text' => Yii::t('app', 'Text'),
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
