<?php

namespace app\components\internal\routes;

use app\models\Airports;

/**
 * Class Routes
 * @package app\components\internal\internal\routes
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class Routes
{
    /**
     * String with FPL route
     * @var string|null
     */
    public $route = null;
    /**
     * ICAO code of alternative airport
     * @var string|null
     */
    public $altn = null;
    /**
     * @var Airports|null
     */
    public $altnAirport = null;

    /**
     * @param string $dep ICAO code of departure airport
     * @param string $arr ICAO code of arrival airport
     */
    public function __construct($dep, $arr){
        $data = RoutesRequest::get($dep, $arr);
        if($data){
            $this->route = $data->route;
            $this->altn = $data->altn;

            $this->createAirportObject();
        }
    }

    /**
     * Create object with airport
     */
    private function createAirportObject()
    {
        if($this->altn){
            $this->altnAirport = Airports::icao($this->altn);
        }
    }
}