<?php

namespace app\models;

use app\components\EmailSender;
use yii\base\Security;
use yii\helpers\Url;
use yii\web\Controller;
use yii;

class User extends Users implements \yii\web\IdentityInterface
{
    public $id;
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
    public $email;
    public $last_visited;
    public $authKey;
    public $email_token;
    public $full_name;
    public $country;
    public $blocked;
    public $block_reason;
    public $blocked_by;
    public $language;
    public $created_date;
    public $mail;

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
        $user->id = $data->vid;
        $user->skype = $data->skype;
        $user->ratingatc = $data->ratingatc;
        $user->ratingpilot = $data->ratingpilot;
        $user->division = $data->division;
        $user->authKey = $sec->generateRandomString(32);
        $user->last_visited = date('Y-m-d H:i:s');
        $user->save();
    }

    public static function setMainData($data, $post)
    {
        $user = new Users();
        $user->vid = $data->vid;
        $user->id = $user->vid;
        $user->created_date = date('Y-m-d H:i:s');
        $user->country = $data->country;
        $user->email = $post['email'];
        $user->language = $post['language'];
        $token = Yii::$app->security->generateRandomString();
        $user->email_token = $token;
        self::setChangeableData($data, $user);

        EmailSender::sendConfirmationMail($user, $token);

        $pilot = new UserPilot();
        $pilot->user_id = $data->vid;
        $pilot->status = UserPilot::STATUS_PENDING;
        $pilot->location = 'UUEE';
        $pilot->save();

        $billing_balance = new BillingUserBalance();
        $billing_balance->user_vid = $data->vid;
        $billing_balance->balance = 1500;
        $billing_balance->save();
        Yii::trace($billing_balance->errors);
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

    public function getLevel()
    {
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->level;
    }

    public function getExperience()
    {
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->experience;
    }

    public function getProgress()
    {
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->progress;
    }

    public function getAvatar()
    {
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->avatar;
    }

    public function getStatus()
    {
        return UserPilot::find()->where(['user_id' => $this->vid])->one()->status;
    }

    public function getName(){
        return $this->getOldAttribute('full_name');
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

    public static function checkStatus()
    {
        //$ctrl = new Controller('auth', 'users');
        if (Yii::$app->user->identity->status == UserPilot::STATUS_PENDING) {
            //$ctrl->redirect('/users/auth/confirmemail');
            Yii::$app->getResponse()->redirect(Url::to('/users/auth/confirmemail'))->send();
        }
    }

    public static function setLanguage()
    {
        \Yii::$app->language = (!\Yii::$app->user->isGuest) ? \Yii::$app->user->identity->language : 'EN';
    }
}
