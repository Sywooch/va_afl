<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 20.11.2016
 * Time: 3:30
 */

namespace app\modules\airline\models;

use Yii;

use app\models\Users;
use yii\db\ActiveQuery;

class Sup
{
    /**
     * Return active supervisors list
     * @param bool $returnArray
     * @return array|ActiveQuery
     */
    public static function active($returnArray = false){
        $users = [];

        foreach(Users::active() as $user){
            if (Yii::$app->authManager->checkAccess($user->vid, 'supervisor')) {
                $users[] = $user->vid;
            }
        }

        Yii::trace($users);

        return $returnArray ? $users : Users::find()->where(['vid' => $users]);
    }
}