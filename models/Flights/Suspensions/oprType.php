<?php

namespace app\models\Flights\Suspensions;

/**
 * VA AFL
 *
 * Suspensions Processing
 * Type: operator remarks
 *
 * Search incorrect operator remarks
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
        'VAG AFL',
        'VA AEROFLOT',
        'AFLGROUP',
        'AFL GROUP',
        'AEROFLOT',
        'RMK/OPR',
        'HTTP//VAAEROFLOTSU/',
        'VIRTUAL AIRLINES',
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