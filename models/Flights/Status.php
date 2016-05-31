<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.05.16
 * Time: 0:12
 */

namespace app\models\Flights;

use app\commands\ParseController;
use app\components\Slack;
use app\models\Booking;

/**
 * Class Status
 *
 * TODO: Рефактор check()
 * @author Nikita Fedoseev
 * @package app\models\Flights
 */
class Status
{
    private static $booking;
    private static $status;
    private static $landing;

    const SPEED_BOARDING = 8;
    const SPEED_ENROUTE = 100;
    const SPEED_APP_MH = 200;
    const SPEED_APP_L = 140;

    public static function get($booking, $landing = false)
    {
        try {
            self::$booking = $booking;
            self::$landing = $landing;
            self::$status = $booking->g_status;
            self::check();
            self::save();
            self::$status = 0;
        } catch (\Exception $ex) {
            var_dump($ex);
        }
    }

    private static function check()
    {
        switch (self::$booking->status) {
            case Booking::BOOKING_INIT:
                self::$status = Booking::STATUS_BOOKED;
                break;

            case Booking::BOOKING_FLIGHT_START:
                if (self::$status == Booking::STATUS_LOSS) {
                    self::$status = 0;
                }
                self::checkFlightStart();
                break;

            case Booking::BOOKING_FLIGHT_END:
                self::checkFlightEnd();
                break;

            case Booking::BOOKING_DELETED_BY_USER:
                self::$status = Booking::STATUS_CANCELED;
                break;
        }
    }

    private static function save()
    {
        if (self::$booking->g_status != self::$status && self::$status != 0) {
            self::$booking->g_status = self::$status;

            $slack = new Slack('#dev_reports', "Status of " . self::$booking->callsign . " has been changed to " . self::$status);
            $slack->sent();
        }

        self::$booking->save();
    }

    private static function checkFlightStart()
    {
        if (isset(self::$booking->flight->lastTrack)) {
            if (self::$booking->flight->lastTrack->groundspeed < self::SPEED_BOARDING || self::$status == Booking::STATUS_BOOKED) {
                self::$status = Booking::STATUS_BOARDING;
            }

            if (self::$booking->flight->lastTrack->groundspeed >= self::SPEED_BOARDING) {
                self::$status = Booking::STATUS_DEPARTING;
            }

            if (self::$booking->flight->lastTrack->groundspeed >= self::SPEED_ENROUTE) {
                self::$status = Booking::STATUS_ENROUTE;
            }

            if (self::$booking->flight->lastTrack->groundspeed <= self::SPEED_APP_MH
                && in_array(self::$booking->fleet->actypes->turbulence, ['H', 'M'])
                && self::$landing && self::$status == Booking::STATUS_ENROUTE
            ) {
                if (self::$landing != self::$booking->from_icao) {
                    self::$status = Booking::STATUS_APPROACH;
                }
            }

            if (self::$booking->flight->lastTrack->groundspeed <= self::SPEED_APP_L
                && in_array(self::$booking->fleet->actypes->turbulence, ['L'])
                && self::$landing && self::$status == Booking::STATUS_ENROUTE
            ) {
                if (self::$landing != self::$booking->from_icao) {
                    self::$status = Booking::STATUS_APPROACH;
                }
            }

            if (self::$booking->flight->landing) {
                self::$status = Booking::STATUS_LANDED;

                if (self::$booking->flight->lastTrack->groundspeed == 0 && self::$status == Booking::STATUS_LANDED) {
                    self::$status = Booking::STATUS_ON_BLOCKS;
                }
            }

            if ((gmmktime() - strtotime(self::$booking->flight->last_seen)) > ParseController::HOLD_TIME / 2) {
                self::$status = Booking::STATUS_LOSS;
            }
        } else {
            self::$status = Booking::STATUS_BOARDING;
        }
    }

    private
    static function checkFlightEnd()
    {
        if (!empty(self::$booking->flight->landing)) {
            switch (self::$booking->flight->landing) {
                case self::$booking->flight->to_icao:
                    self::$status = Booking::STATUS_ARRIVED;
                    break;
                case self::$booking->flight->from_icao:
                    self::$status = Booking::STATUS_RETURNED;
                    break;
                case self::$booking->flight->alternate1:
                case self::$booking->flight->alternate2:
                    self::$status = Booking::STATUS_RETURNED_TO_ALT;
                    break;
                default:
                    self::$status = Booking::STATUS_FAILED;
            }
        }
    }
} 