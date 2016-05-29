<?php

namespace app\models\Services\Notifications;

use Yii;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property integer $to
 * @property integer $from
 * @property integer $content_id
 * @property integer $read
 * @property string $created
 * @property string $tag
 * @property string $tag_color
 * @property string $link
 *
 * @property Users $to0
 * @property Content $content
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'content_id', 'read'], 'required'],
            [['to', 'from', 'content_id', 'read'], 'integer'],
            [['created'], 'safe'],
            [['tag', 'tag_color', 'link'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'to' => Yii::t('app', 'To'),
            'from' => Yii::t('app', 'From'),
            'content_id' => Yii::t('app', 'Content ID'),
            'read' => Yii::t('app', 'Read'),
            'created' => Yii::t('app', 'Created'),
            'tag' => Yii::t('app', 'Tag'),
            'tag_color' => Yii::t('app', 'Tag Color'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo0()
    {
        return $this->hasOne(Users::className(), ['vid' => 'to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
