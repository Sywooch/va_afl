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
class mvzType implements SuspensionProcess
{
    /**
     * @var \app\models\Flights
     */
    private $flight;

    /**
     * Moscow Aiports
     * @var array
     */
    private $airports = [
        'UUEE',
        'UUDD',
        'UUWW',
        'UUMO',
        'UUBW',
    ];
    /**
     * Incorrect transition routes
     * @var array
     */
    private $transitions = [
        'MF1T',
        'MF3T',
        'MF6T',
        'FE2T',
        'FE3T',
        'FE4T',
        'NAM4T',
        'NAM1T',
        'FK1T',
    ];

    /**
     * Check
     * @param \app\models\Flights $flight
     * @return mixed|void
     */
    public function startCheck($flight)
    {
        $this->flight = $flight;

        $suspensions = [];
        if (in_array($this->flight->from_icao, $this->airports)
            || in_array($this->flight->to_icao, $this->airports)
        ) {
            if ($transitions = $this->checkTransitions()) {
                $suspensions[] = [
                    'Транзитные маршруты', 'Transitions Routes', $transitions, 726
                ];
            }
        }

        return $suspensions;
    }

    /**
     * Check Transitions
     *
     * @return bool|string
     */
    private function checkTransitions()
    {
        $errors = [];
        foreach ($this->transitions as $transition) {
            if (strpos($this->flight->flightplan, $transition)) {
                $errors[] = $transition;
            }
        }

        if (!empty($errors)) {
            \Yii::trace($errors);
            $string = '';
            foreach ($errors as $transition) {
                if ($string != '') {
                    $string .= ', ';
                }
                $string .= $transition;
            }
            return $string;
        } else {
            return false;
        }
    }
}