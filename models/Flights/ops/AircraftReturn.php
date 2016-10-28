<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 09.10.16
 * Time: 1:24
 */

namespace app\models\Flights\ops;


use app\models\Fleet;
use app\models\Flights;
use app\models\Services\notifications\FlightOps;

class AircraftReturn
{
    /**
     * @var \app\models\Flights
     */
    private $flight;

    /**
     * @param Flights $flight
     */
    public function __construct(Flights $flight)
    {
        if (strtotime($flight->landing_time) < strtotime(date('Y-m-d', strtotime('-2 week', time())))) {
            $this->flight = $flight;
            $this->move();
            FlightOps::aircraftReturn($flight);
        }
    }

    private function move()
    {
        $this->flight->fleet->status = Fleet::STATUS_AVAIL;
        $this->flight->fleet->location = $this->flight->fleet->home_airport;
        $this->flight->fleet->save();
    }
} 