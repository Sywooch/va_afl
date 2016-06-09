<?php

namespace app\models\Tours;

use Yii;

/**
 * This is the model class for table "{{%tours_legs}}".
 *
 * @property integer $id
 * @property integer $tour_id
 * @property integer $leg_id
 * @property string $from
 * @property string $to
 *
 * @property Tours $tour
 */
class ToursLegs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tours_legs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'leg_id', 'from', 'to'], 'required'],
            [['tour_id', 'leg_id'], 'integer'],
            [['from', 'to'], 'string', 'max' => 4]
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
            'leg_id' => Yii::t('app', 'Leg ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tours::className(), ['id' => 'tour_id']);
    }
}
