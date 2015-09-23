<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ranks".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_eng
 */
class Ranks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ranks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_eng'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_eng' => 'Name Eng',
        ];
    }
}
