<?php
namespace app\models\Flights\Suspensions;

/**
 * VA AFL
 *
 * Suspensions Processing
 * Interface
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
interface SuspensionProcess
{
    /**
     * Start check flight to suspension
     * @param \app\models\Flights $flight
     * @return mixed
     */
    public function startCheck($flight);
}