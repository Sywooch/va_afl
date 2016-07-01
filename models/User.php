<?php

namespace app\models;

use yii\base\Security;
use yii\web\Controller;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $vid;
    public $firstname;
    public $lastname;
    public $rating;
    public $skype;
    public $ratingatc;
    public $ratingpilot;
    public $division;
    public $username;
    public $result;
    public $id;
    public $email;
    public $last_visited;
    public $authKey;
    public $full_name;
    public $country;
    public $blocked;
    public $block_reason;
    public $blocked_by;
    public $language;
    public $created_date;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = Users::findOne($id);

        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @param IvaoLogin $data из IVAO API
     * @param Users $user из текущей модели
     */
    public static function setChangeableData($data, $user)
    {
        $sec = new Security();
        $user->full_name = $data->username;
        $user->skype = $data->skype;
        $user->ratingatc = $data->ratingatc;
        $user->ratingpilot = $data->ratingpilot;
        $user->division = $data->division;
        $user->authKey = $sec->generateRandomString(32);
        $user->last_visited = date('Y-m-d H:i:s');
        $user->save();
    }

    public static function setMainData($data)
    {
        $user = new Users();
        $user->vid = $data->vid;
        $user->created_date = date('Y-m-d H:i:s');
        $user->country = $data->country;
        $user->language = $data->language;
        self::setChangeableData($data, $user);
        
        /*$pilot = new UserPilot();
        $pilot->user_id = $data->vid;
        $pilot->status = 0;
        $pilot->location = 'UUEE';
        $pilot->save();*/
    }
    
    /*public static function findByUsername($model)
    {
        $needrelation = false;
        $sec = new Security();
        if (!$user = Users::findOne($model->vid)) {
            $user = new Users();
            $user->vid = $model->vid;
            $user->full_name = $model->username;
            $user->created_date = date('Y-m-d H:i:s');
            $user->country = $model->country;
            $user->language = (in_array($model->country, ['RU'])) ? 'RU' : 'EN';
            $needrelation = true;
        }

        if($needrelation)
        {
            $pilot = new UserPilot();
            $pilot->user_id = $model->vid;
            $pilot->status = 0;
            $pilot->location = 'UUEE';
            $pilot->save();
        }



        //check the forum user exists;
        /*if(!$forummember=SmfMembers::findOne(['member_name'=>$user->username]))
        {
            $forummember=new SmfMembers();
            $forummember->member_name=$user->username;
            $forummember->date_registered=intval(strtotime($user->register_date));
            $forummember->real_name=$user->username;
            if(!$forummember->save())
            {
                VarDumper::dump($forummember->errors,10,true);
            }
        }

        return new static($user);
    }*/

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->vid;
    }

    public function getLevel(){
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->level;
    }

    public function getProgress(){
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->progress;
    }

    public function getAvatar(){
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->avatar;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function checkEmail()
    {
        $ctrl = new Controller('site', 'app');
        if (!\Yii::$app->user->identity->email) {
            $ctrl->redirect('/pilot/edit');
        }
    }

    public static function setLanguage()
    {
        \Yii::$app->language = (!\Yii::$app->user->isGuest) ? \Yii::$app->user->identity->language : 'EN';
    }
}
