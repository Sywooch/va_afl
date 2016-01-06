<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $staff_position
 * @property string $name_ru
 * @property string $name_en
 * @property integer $vid
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_position', 'name_ru', 'name_en', 'vid'], 'required'],
            [['vid'], 'integer', 'min' => 100000, 'max' => 999999],
            [['staff_position'], 'string', 'max' => 5],
            [['name_ru', 'name_en'], 'string', 'max' => 55],
            [['staff_position'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_position' => Yii::t('app', 'Code of Staff Position'),
            'name_ru' => Yii::t('app', 'Staff Position'),
            'name_en' => Yii::t('app', 'Staff Position'),
            'vid' => Yii::t('app', 'VID'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'vid']);
    }
}
