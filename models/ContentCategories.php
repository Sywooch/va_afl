<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_categories".
 *
 * @property integer $id
 * @property string $link
 * @property string $name_ru
 * @property string $name_en
 * @property string $access_read
 * @property string $access_edit
 */
class ContentCategories extends \yii\db\ActiveRecord
{

    public static function news()
    {
        return self::available(self::find()->where(['news' => 1])-> all(), true);
    }

    public static function available($data = null, $object = false){
        $categories = [];

        if($data == null){
            $data = self::find()->all();
        }

        foreach($data as $cat){
            if(empty($cat->access) || Yii::$app->user->can($cat->access))
            {
                if($object == false){
                    $categories[$cat->id] = $cat->name;
                }else{
                    $categories[] = $cat;
                }
            }
        }
        return $categories;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'name_ru', 'name_en'], 'required'],
            [['link'], 'string', 'max' => 20],
            [['news', 'notifications'], 'integer'],
            [['name_ru', 'name_en', 'access_read', 'access_edit', 'access_feed'], 'string', 'max' => 50],
            [['link_to'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'link' => Yii::t('app', 'Link'),
            'link_to' => Yii::t('app', 'Link To'),
            'name_ru' => Yii::t('app', 'Name') .' '.Yii::t('app', '(Ru.)'),
            'name_en' => Yii::t('app', 'Name') .' '.Yii::t('app', '(En.)'),
            'access' => Yii::t('app', 'Access'),
        ];
    }

    public function getName(){
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

    public function getContent(){
        return $this->hasMany('app\models\Content', ['category' => 'id']);
    }
}