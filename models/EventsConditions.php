<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events_conditions".
 *
 * @property integer $event_id
 * @property string $relation
 * @property string $variable
 * @property string $value
 *
 * @property Events $event
 */
class EventsConditions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events_conditions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id'], 'integer'],
            [['value'], 'required'],
            [['relation', 'variable', 'value'], 'string', 'max' => 50],
            [['event_id', 'relation', 'variable', 'value'], 'unique', 'targetAttribute' => ['event_id', 'relation', 'variable', 'value'], 'message' => 'The combination of Event ID, Relation, Variable and Value has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('app', 'Event ID'),
            'relation' => Yii::t('app', 'Relation'),
            'variable' => Yii::t('app', 'Variable'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }
}
