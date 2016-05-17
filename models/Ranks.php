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
    public function getName()
    {
        return Yii::$app->language == 'ru' ? $this->name_ru : $this->name_en;
    }
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
            [['name_ru', 'name_en'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Звание',
            'name_en' => 'Rank',
        ];
    }

    /**
     * Вернёт имя
     * @return string
     */
    public function getName()
    {
        return $this->getLocale('name_ru', 'name_en');
    }

    /**
     * Возвращает переменную взависимости от языка
     * @param $ru string
     * @param $en string
     * @return string
     */
    private function getLocale($ru, $en)
    {
        return Yii::$app->language == 'RU' ? $this->$ru : $this->$en;
    }
}
