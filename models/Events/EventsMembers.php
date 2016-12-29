<?php

namespace app\models\Events;

use Yii;

/**
 * This is the model class for table "{{%events_members}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $flight_id
 * @property string $request
 * @property string $accepted
 * @property integer $accepted_by
 */
class EventsMembers extends \yii\db\ActiveRecord
{
    const STATUS_REQ = 0;
    const STATUS_REJECTED = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_ACTIVE_FLIGHT = 3;
    const STATUS_FINISHED_FLIGHT = 4;

    public $date;
    public $count_members;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%events_members}}';
    }

    public static function get($event, $flight)
    {
        return EventsMembers::find()->where(['event_id' => $event->id])->andWhere(['flight_id' => $flight->id])->one();
    }

    public static function flight($flight)
    {
        return EventsMembers::find()->andWhere(['flight_id' => $flight->id])->all();
    }

    public static function stats($limit, $order)
    {
        $members = self::find()->joinWith('event')->select([
            'DATE(events.start) as date',
            'COUNT(DISTINCT events_members.id) as count_members'
        ])->groupBy('DATE(events.start)')->orderBy('events_members.id ' . $order);

        if ($limit > 0) {
            $members = $members->limit($limit);
        }

        return $members->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id'], 'required'],
            [['event_id', 'user_id', 'status', 'flight_id', 'accepted_by'], 'integer'],
            [['request', 'accepted'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'flight_id' => Yii::t('app', 'Flight ID'),
            'request' => Yii::t('app', 'Request'),
            'accepted' => Yii::t('app', 'Accepted'),
            'accepted_by' => Yii::t('app', 'Accepted By'),
        ];
    }

    public function getExp(){
        return $this->event->type * ($this->event->center ? 5 : 1) * 29;
    }

    public function getVucs(){
        return $this->event->type * ($this->event->center ? 5 : 1) * 22;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(\app\models\Flights::className(), ['id' => 'flight_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(\app\models\Events\Events::className(), ['id' => 'event_id']);
    }
}
