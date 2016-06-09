<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 22.05.16
 * Time: 5:17
 */

namespace app\components;


use app\models\Content;
use app\models\Services\notifications\Notification;
use app\models\UserPilot;

class Levels
{
    const TEMPLATE = 798;

    public static function addExp($exp, $user)
    {
        $user = UserPilot::find()->where(['user_id' => $user])->one();
        $level = $user->level;
        $user->experience = $user->experience + $exp;

        while ($user->experience >= self::getNextLevel($user->level)) {
            $user->level++;
        }

        if ($user->level > $level) {
            $array = [
                '[level]' => $user->level,
            ];

            Notification::add($user->user_id, 0, Content::template(self::TEMPLATE, $array));
        }

        $user->save();
    }

    public static function exp($user)
    {
        return UserPilot::find()->where(['user_id' => $user])->one()->experience;
    }

    public static function getNextLevel($level)
    {
        return (($level + 1) * 50) - 50;
    }

    public static function getProgress($exp, $level)
    {
        $_level = self::getNextLevel($level);
        return round($exp / $_level * 100);
    }

    public static function flight($user_id, $nm)
    {
        self::addExp(round($nm / 50) + 1, $user_id);
    }
} 