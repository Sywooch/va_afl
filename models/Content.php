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
 * @property int $author
 * @property string $created
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
            [['name_ru', 'name_en', 'text_ru', 'text_en', 'category'], 'required'],
            [['text_ru', 'text_en', 'description_ru', 'description_en', 'machine_name'], 'string'],
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
            'name_ru' => Yii::t('app', 'Name') .' '.Yii::t('app', '(Ru.)'),
            'name_en' => Yii::t('app', 'Name') .' '.Yii::t('app', '(En.)'),
            'text_ru' => Yii::t('app', 'Text') .' '.Yii::t('app', '(Ru.)'),
            'text_en' => Yii::t('app', 'Text') .' '.Yii::t('app', '(En.)'),
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
     * Вернёт текст
     * @return string
     */
    public function getText()
    {
        return $this->getLocale('text_ru', 'text_en');
    }

    public function getDescription()
    {
        return $this->getLocale('description_ru', 'description_en');
    }

    public function getAuthorUser()
    {
        return $this->hasOne('app\models\Users', ['vid' => 'author']);
    }

    public function getCategoryInfo()
    {
        return $this->hasOne('app\models\ContentCategories', ['id' => 'category']);
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
