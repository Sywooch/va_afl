<?php

namespace app\components;

/**
 * IVAO Tools
 *
 * IVAO Weather Model
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class IvaoWx
{
    /**
     * Get Metar
     * @param string $icao
     * @return string
     */
    public static function metar($icao)
    {
        return file_get_contents("http://wx.ivao.aero/metar.php?id=$icao");
    }

    /**
     * Get TAF
     * @param string $icao
     * @return string
     */
    public static function taf($icao)
    {
        return file_get_contents("http://wx.ivao.aero/taf.php?id=$icao");
    }
}