<?php

namespace app\models\Events;

use Yii;

/**
 * This is the model class for table "events_categories".
 *
 * @property integer $event_id
 * @property integer $category_id
 */
class EventsCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['event_id', 'category_id'], 'unique', 'targetAttribute' => ['event_id', 'category_id'], 'message' => 'The combination of Event ID and Category ID has already been taken.'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('app', 'Event ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
}
