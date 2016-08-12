<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 27.06.15
 * Time: 18:26
 */
namespace app\models;

use yii;
use yii\base\Model;

class IvaoLogin extends Model
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
    public $country;
    public $result;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [
                [
                    'vid',
                    'firstname',
                    'lastname',
                    'rating',
                    'skype',
                    'ratingatc',
                    'ratingpilot',
                    'division',
                    'result',
                    'country'
                ],
                'required'
            ],
            ['rememberMe', 'boolean'],

        ];
    }

    public function load($data, $formName = null)
    {
        if ($data['firstname'] && $data['lastname']) {
            $this->username = $data['firstname'] . " " . $data['lastname'];
        }
        parent::load($data, $formName);
    }

    public function login($token)
    {
        $data = json_decode(file_get_contents(Yii::$app->params['ivao_tools_api_url'] . $token), true);
        $this->load($data, '');
        $user = $this->getUser();
        if ($user->vid == null) {
            return false;
        }
        User::setChangeableData($this, Users::findOne(['vid' => $user->vid]));
        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    public function register($post, $token)
    {
        $data = json_decode(file_get_contents(Yii::$app->params['ivao_tools_api_url'] . $token), true);
        $this->load($data, '');
        User::setMainData($this, $post);
    }


    public function getUser()
    {
        //return User::findByUsername($this);
        return User::findIdentity($this->vid);
    }
}