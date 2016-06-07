<?php

namespace app\models\Flights\Suspensions;

/**
 * AFL Group
 *
 * Suspensions Processing
 * Type: eet time
 *
 * Check FOB and EET times
 *
 * Automatic Template
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class eetType implements SuspensionProcess
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

        if (strtotime($flight->eet) >= strtotime($flight->fob)) {
            return [
                [
                    'EET is bigger than FOB',
                    'EET больше, чем FOB',
                    null,
                    775
                ]
            ];
        } else {
            return [];
        }
    }
}