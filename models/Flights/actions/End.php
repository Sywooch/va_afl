<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 07.01.2017
 * Time: 8:59
 */

namespace app\models\Flights\actions;


use app\commands\ParseController;
use app\components\Levels;
use app\components\Slack;
use app\components\Transfer;
use app\models\Billing;
use app\models\Booking;
use app\models\Fleet;
use app\models\Flights;
use app\models\Flights\Status;

class End
{
    public static function make($flight)
    {
        if ($flight->status != Flights::FLIGHT_STATUS_OK) {
            if ($flight->landing) {
                $flight->finished = gmdate('Y-m-d H:i:s');
                $flight->status = Flights::FLIGHT_STATUS_OK;
                $flight->booking->status = Booking::BOOKING_FLIGHT_END;
                $flight->flight_time = intval((strtotime($flight->landing_time) - strtotime($flight->dep_time)) / 60);
                if ($flight->flight_time < 0) {
                    $flight->flight_time = intval((strtotime($flight->last_seen) - strtotime($flight->dep_time)) / 60);
                }

                Transfer::transferPilot($flight->user_id, $flight->landing);

                if ($flight->booking->fleet_regnum) {
                    Transfer::transferCraft($flight->fleet_regnum, $flight->landing);
                    Fleet::changeStatus($flight->booking->fleet_regnum, Fleet::STATUS_AVAIL);
                    Fleet::checkSrv($flight->booking->fleet_regnum, $flight->landing);
                }

                //Биллинг
                $flight->vucs = Billing::calculatePriceForFlight(
                    $flight->from_icao,
                    $flight->landing,
                    unserialize($flight->paxtypes)
                );
                Billing::doFlightCosts($flight);

                //Уровни
                Levels::flight($flight->user_id, $flight->nm);
            } else {
                if ((gmmktime() - strtotime($flight->last_seen)) > ParseController::HOLD_TIME) {
                    if (empty($flight->landing_time)) {
                        $flight->landing_time = $flight->last_seen;
                    }
                    $flight->status = Flights::FLIGHT_STATUS_BREAK;
                    $flight->booking->status = Booking::BOOKING_FLIGHT_END;

                    //Разблокировка борта
                    if ($flight->booking->fleet_regnum) {
                        Fleet::changeStatus($flight->booking->fleet_regnum, Fleet::STATUS_AVAIL);
                    }

                    if (ParseController::$slackFeed) {
                        $slack = new Slack('#dev_reports',
                            "http://va-afl.su/airline/flights/view/{$flight->id} failed.");
                        $slack->sent();
                    }
                }
            }

            $flight->booking->save();
            $flight->save();

            Status::get($flight->booking, $flight->landing);
        }
    }
}