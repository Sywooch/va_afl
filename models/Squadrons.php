<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "squads".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $abbr_ru
 * @property string $abbr_en
 */
class Squadrons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'squadrons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en', 'abbr_ru', 'abbr_en'], 'string', 'max' => 100],
            [['leader'], 'integer'],
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
            'name_en' => 'Name En',
            'abbr_ru' => 'Abbr Ru',
            'abbr_en' => 'Abbr En',
            'leader' => 'Leader',
        ];
    }
}
