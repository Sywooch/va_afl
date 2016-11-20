<?php

namespace app\models\Staff;

use Yii;
use yii\helpers\ArrayHelper;

use app\models\Users;

/**
 * This is the model class for table "staff_sups".
 *
 * @property integer $user_id
 */
class StaffSups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_sups';
    }

    public static function clear()
    {
        self::deleteAll();
    }

    public static function write($sups)
    {
        foreach($sups as $sup){
            $model = new self;
            $model->user_id = $sup;
            $model->save();
        }
    }

    public static function active()
    {
        return Users::find()->where(['vid' => ArrayHelper::getColumn(self::find()->all(), 'user_id')]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Vid',
        ];
    }
}
