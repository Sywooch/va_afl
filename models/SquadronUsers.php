<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "squad_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $squad_id
 * @property integer $approved
 * @property integer $is_leader
 */
class SquadronUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 0;
    const STATUS_PENDING = 2;

    public static function tableName()
    {
        return 'squadron_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'squadron_id'], 'required'],
            [['user_id', 'squadron_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'squadron_id' => 'Squadron ID',
            'status' => 'Status',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public function getLastFlight()
    {
        return Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $this->squadron_id)->andWhere(['flights.user_id' => $this->user_id])->orderBy(['flights.id' => SORT_DESC])->one();
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_SUSPENDED => Yii::t('user', 'Suspended'),
            self::STATUS_ACTIVE => Yii::t('user', 'Active'),
            self::STATUS_PENDING => Yii::t('user', 'Pending'),
        ];
    }

    public function getAcceptedByUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'accepted_by']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }
}
