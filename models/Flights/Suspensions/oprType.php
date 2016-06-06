<?php

namespace app\models\Flights\Suspensions;

/**
 * AFL Group
 *
 * Suspensions Processing
 * Type: mvz routes
 *
 * Search incorrect transitions
 *
 * Automatic Template
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class oprType implements SuspensionProcess
{
    /**
     * @var \app\models\Flights
     */
    private $flight;

    private $errors = [
        'VA AFL',
        'VAG AFL',
        'VA AEROFLOT',
        'AEROFLOT',
        'RMK/OPR',
    ];

    /**
     * Check
     * @param \app\models\Flights $flight
     * @return mixed|void
     */
    public function startCheck($flight)
    {
        $this->flight = $flight;

        foreach ($this->errors as $error) {
            if (strpos($this->flight->remarks, $error)) {
                return [
                    [
                        'Неправильная ремарка OPR/',
                        'Incorrect OPR/ remark',
                        $error,
                        730
                    ]
                ];
            }
        }

        return [];
    }
}