<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "isocodes".
 *
 * @property string $code
 * @property string $country
 */
class Isocodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'isocodes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['country'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'country' => 'Country',
        ];
    }
}
