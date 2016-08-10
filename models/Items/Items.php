<?php

namespace app\models\Items;

use Yii;

use app\models\Users;
/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $user_id
 * @property integer $available
 * @property integer $cost
 * @property integer $days
 * @property integer $temporary
 * @property string $temporary_stop
 * @property string $created
 *
 * @property ItemsTypes $type
 * @property Users $user
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    public static function shop()
    {
        return self::find()->where(['available' => 1])->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id', 'user_id', 'available', 'temporary', 'days'], 'integer'],
            [['temporary_stop', 'created'], 'safe'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemsTypes::className(), 'targetAttribute' => ['type_id' => 'type_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'vid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'available' => Yii::t('app', 'Available'),
            'cost' => Yii::t('app', 'Cost'),
            'days' => Yii::t('app', 'Days'),
            'temporary' => Yii::t('app', 'Temporary'),
            'temporary_stop' => Yii::t('app', 'Stop'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public function getCreatedDT(){
        return new \DateTime($this->created);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ItemsTypes::className(), ['type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }
}
