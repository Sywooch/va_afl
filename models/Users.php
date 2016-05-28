<?php

namespace app\models;

use Yii;
use app\components\Helper;

/**
 * This is the model class for table "users".
 *
 * @property integer $vid
 * @property string $full_name
 * @property string $email
 * @property string $country
 * @property string $authKey
 * @property integer $blocked
 * @property string $block_reason
 * @property integer $blocked_by
 * @property string $language
 * @property string $created_date
 * @property string $last_visited
 */
class Users extends \yii\db\ActiveRecord
{
    const SCENARIO_EDIT = 'editprofile';

    /**
     * Перемещает пилота
     */
    public static function transfer($vid, $location)
    {
        $user = self::find()->andWhere(['vid' => $vid])->one();
        $user->pilot->location = $location;
        $user->pilot->save();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    public static function getUserName($id)
    {
        $user = self::find()->where(['vid' => $id])->one();
        return $user ? $user->full_name : '';
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['vid'];
        $scenarios[self::SCENARIO_EDIT] = ['vid', 'email', 'language'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid'], 'required'],
            [['email', 'language'], 'required', 'on' => self::SCENARIO_EDIT],
            [['vid'], 'integer'],
            [['authKey'], 'string'],
            [['created_date', 'last_visited', 'language'], 'safe'],
            [['full_name', 'email'], 'string', 'max' => 200],
            [['stream'], 'string', 'max' => 255],
            [['country', 'language'], 'string', 'max' => 2],
            [['avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vid' => 'IVAO ID',
            'full_name' => Yii::t('user', 'Full Name'),
            'email' => 'Email',
            'country' => Yii::t('user', 'Country'),
            'authKey' => 'Auth Key',
            'language' => 'Language/Язык',
            'created_date' => Yii::t('user', 'Register Date'),
            'last_visited' => Yii::t('user', 'Last Visited'),
            'avatar' => Yii::t('user', 'Avatar'),
            'stream' => Yii::t('user', 'Stream Channel'),
        ];
    }

    public function getPilot()
    {
        return $this->hasOne(UserPilot::className(), ['user_id' => 'vid']);
    }

    public function getCountryInfo()
    {
        return $this->hasOne(Isocodes::className(), ['code' => 'country']);
    }

    public static function findIdentity($id)
    {
        return \app\models\User::findIdentity($id);
    }

    public static function getAuthUser()
    {
        return self::find()->andWhere(['vid' => Yii::$app->user->id])->one();
    }

    public function getOnline()
    {
        return (strtotime($this->last_visited) > strtotime('-10 minutes')) ? true : false;
    }

    public function getFlaglink()
    {
        return Helper::getFlagLink($this->country);
    }

    public function getAvatarLink(){
        return Helper::getAvatarLink((isset($this->pilot->avatar) && file_exists(Yii::getAlias('@app/web/img/avatars/') . $this->pilot->avatar)) ? $this->pilot->avatar : 'default.png');
    }

    public function getAvatar(){
        return $this->pilot->avatar;
    }

    public static function active(){
        return self::find()->joinWith('pilot')->where(['user_pilot.status' => 1])->all();
    }
}
