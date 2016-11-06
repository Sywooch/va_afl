<?php

namespace app\models\Flights\Suspensions;

/**
 * VA AFL
 *
 * Suspensions Processing
 * Type: airbus a330 type
 *
 * Check acf type
 *
 * Automatic Template
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class a330Type implements SuspensionProcess
{
    /**
     * @var \app\models\Flights
     */
    private $flight;

    /**
     * Check
     * @param \app\models\Flights $flight
     * @return mixed|void
     */
    public function startCheck($flight)
    {
        $this->flight = $flight;

        if ($flight->acf_type == 'A330') {
            return [
                [
                    'В своём полётном плане вы указали тип самолёта A330, которого не существует',
                    'You have put A330 type in your flight plan which is invalid',
                    null,
                    4632
                ]
            ];
        } else {
            return [];
        }
    }
}