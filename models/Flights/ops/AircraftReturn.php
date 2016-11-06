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
use DateTime;

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
        $first_seen = new DateTime($flight->first_seen);
        $time_to_diff = (new DateTime())->modify('-14 day');
        if ($first_seen < $time_to_diff) {
            $this->flight = $flight;
            FlightOps::aircraftReturn($flight);
            $this->move();
        }
    }

    private function move()
    {
        $this->flight->fleet->status = Fleet::STATUS_AVAIL;
        $this->flight->fleet->location = $this->flight->fleet->home_airport;
        $this->flight->fleet->save();
    }
} 