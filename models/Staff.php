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
     * @param $id int
     * @return $this
     */
    public static function getSquad($id){
        return self::find()->where(['department' => 'Squadrons'])->andWhere(['direction' => $id]);
    }

    public static function byUser($id){
        return self::find()->where(['vid' => $id])->all();
    }

    public static function roles($id){
        $text = '';
        foreach(self::byUser($id) as $role){
            if($text != ''){
                $text .= ", \n";
            }
            $text .= $role->name_en;
        }

        return $text;
    }

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
