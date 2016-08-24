<?php


namespace app\components\internal\routes;

/**
 * Class RoutesRequest
 *
 * @package app\components\internal\internal\routes
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class RoutesRequest
{
    /**
     * 12 hours cache
     */
    const CACHE_TIME = 43200;

    /**
     * Get Route Info
     * @param string $dep ICAO code of departure airport
     * @param string $arr ICAO code of arrival airport
     * @return object
     */
    public static function get($dep, $arr)
    {
        if (!$data = \Yii::$app->cache->get("routes-$dep-$arr")) {
            $data = self::request($dep, $arr);
            \Yii::$app->cache->set('ivao_events', $data, self::CACHE_TIME);
        }

        return $data;
    }

    /**
     * Request data by file_get_contents
     * @param string $dep ICAO code of departure airport
     * @param string $arr ICAO code of arrival airport
     * @return mixed
     */
    public static function request($dep, $arr)
    {
        return json_decode(file_get_contents("http://routes.app.va-afl.su/index.php?dep=$dep&arr=$arr"));
    }
} 