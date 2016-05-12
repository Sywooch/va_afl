<?php

namespace app\models\Events;

use Yii;

use app\models\Content;
use app\models\Users;

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
    const CONTENT_CATEGORY = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    private static function eventArray($all)
    {
        $events = [];
        foreach($all as $event){
            $events[$event['id']] = $event;
            $events[$event['id']]['content'] = Content::find()->where(['id' => $event['content']])->asArray()->one()    ;
        }
        return $events;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'start', 'stop'], 'required'],
            [['content', 'author', 'type', 'free_join', 'center'], 'integer'],
            [['access'], 'string'],
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

    public static function center($array = false)
    {
        $request = self::find()->where('DATE(NOW()) < DATE(start) OR (DATE(NOW()) >= DATE(start) AND DATE(NOW()) <= DATE(stop))')->andWhere(['center' => 1])->orderBy(['start' => SORT_ASC]);
        return $array ? self::eventArray($request->asArray()->all()) : $request->all();
    }

    public function getColor(){
        switch($this->type){
            case 10:
                return 'blue';
                break;
            case 20:
                return 'green';
                break;
            case 30:
                return 'red';
                break;
            default:
                return 'black';
                break;
        }
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
