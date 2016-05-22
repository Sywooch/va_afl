<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 22.05.16
 * Time: 5:17
 */

namespace app\components;


use app\models\UserPilot;

class Levels {
    public static function addExp($exp, $user)
    {
        $user = UserPilot::find()->where(['user_id' => $user])->one();
        $user->experience = $user->experience + $exp;
        while($user->experience >= self::getNextLevel($user->level))
        {
            $user->level++;
        }

        $user->save();
    }

    public static function getNextLevel($level)
    {
        return (($level + 1) * 50) - 50;
    }

    public static function getProgress($exp, $level){
        $_level = self::getNextLevel($level);
        return round($exp / $_level * 100);
    }
} 