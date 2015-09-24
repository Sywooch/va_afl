<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $text_ru
 * @property string $text_en
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en', 'text_ru', 'text_en'], 'required'],
            [['text_ru', 'text_en'], 'string'],
            [['name_ru', 'name_en'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'text_ru' => Yii::t('app', 'Text Ru'),
            'text_en' => Yii::t('app', 'Text En'),
        ];
    }

    /**
     * Вернёт имя
     * @return string
     */
    public function getName(){
        return $this->getLocale('name_ru', 'name_en');
    }

    /**
     * Вернёт текст
     * @return string
     */
    public function getText(){
        return $this->getLocale('text_ru', 'text_en');
    }

    /**
     * Возвращает переменную взависимости от языка
     * @param $ru string
     * @param $en string
     * @return string
     */
    private function getLocale($ru, $en){
        return Yii::$app->language == 'RU' ? $this->$ru : $this->$en;
    }
}
