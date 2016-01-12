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
            [['user_id', 'squad_id'], 'required'],
            [['user_id', 'squad_id', 'approved', 'is_leader'], 'integer']
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
            'squad_id' => 'Squad ID',
            'status' => 'Status',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_SUSPENDED => Yii::t('user', 'Suspended'),
            self::STATUS_ACTIVE => Yii::t('user', 'Active'),
            self::STATUS_PENDING => Yii::t('user', 'Pending'),
        ];
    }

    public static function getSquadMembers($id)
    {
        return SquadronUsers::find()->where(['squad_id' => $id])->andWhere(['status' => self::STATUS_PENDING]);
    }

    public function getSquadMember()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }
}
