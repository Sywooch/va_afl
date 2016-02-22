<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $text_ru
 * @property string $text_en
 * @property string $img
 * @property string $preview
 * @property int $author
 * @property string $created
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $img_file;
    public $preview_file;

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
            [['category', 'name_ru', 'name_en'], 'required'],
            [['category', 'author'], 'integer'],
            [['text_ru', 'text_en'], 'string'],
            [['created'], 'safe'],
            [['name_ru', 'name_en', 'description_ru', 'description_en'], 'string', 'max' => 50],
            [['img', 'preview'], 'string', 'skipOnEmpty' => true, 'max' => 255],
            [['machine_name'], 'string', 'max' => 100],
            [['machine_name'], 'unique']
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
        return $this->hasOne(ContentCategories::className(), ['id' => 'category']);
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
