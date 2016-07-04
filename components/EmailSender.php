<?php
namespace app\components;

use app\models\Users;
use yii;
use yii\base\Component;

class EmailSender extends Component
{
    /**
     * @param $user Users
     * @param $token string
     */
    public static function sendConfirmationMail($user, $token)
    {
        Yii::$app->mailer->compose('emailConfirm.php', ['user' => $user, 'token' => $token])
            ->setFrom(Yii::$app->params['serverEmail'])
            ->setTo($user->email)
            ->setSubject(Yii::t('email', 'Confirm your account'))
            ->send();
    }
}