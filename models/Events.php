<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property integer $content
 * @property string $start
 * @property string $stop
 * @property integer $author
 * @property string $created
 * @property string $banner
 *
 * @property Content $content
 * @property EventsConditions[] $eventsConditions
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'start', 'stop', 'author'], 'required'],
            [['content', 'author'], 'integer'],
            [['start', 'stop', 'created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'start' => Yii::t('app', 'Start'),
            'stop' => Yii::t('app', 'Stop'),
            'author' => Yii::t('app', 'Author'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentInfo()
    {
        return $this->hasOne(Content::className(), ['id' => 'content']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventsConditions()
    {
        return $this->hasMany(EventsConditions::className(), ['event_id' => 'id']);
    }
}
