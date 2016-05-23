<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.05.16
 * Time: 0:12
 */

namespace app\models\Flights;

use app\components\Slack;
use app\models\Booking;

class Status
{

    private static $status = 0;
    private static $booking;
    private static $landing;

    private static function save()
    {
        if (self::$booking->g_status != self::$status) {
            self::$booking->g_status = self::$status;

            $slack = new Slack('#dev_reports', "Status of " . self::$booking->callsign . " has been changed to " . self::$status);
            $slack->sent();
        }
    }

    private static function check()
    {
        switch (self::$booking->status) {

            case Booking::BOOKING_INIT:
                self::$status = Booking::STATUS_BOOKED;
                break;

            case Booking::BOOKING_FLIGHT_START:
                if (isset(self::$booking->flight->lastTrack)) {
                    if (self::$booking->flight->lastTrack->groundspeed >= 8 && self::$status == Booking::STATUS_BOARDING) {
                        self::$status = Booking::STATUS_DEPARTING;
                    }

                    if (self::$booking->flight->lastTrack->groundspeed >= 50 && self::$status == Booking::STATUS_DEPARTING) {
                        self::$status = Booking::STATUS_ENROUTE;
                    }

                    if (self::$booking->flight->lastTrack->groundspeed <= 200 && in_array(
                            self::$booking->fleet->actypes->weightclass,
                            ['H', 'M']
                        ) && self::$landing && self::$status == Booking::STATUS_ENROUTE
                    ) {
                        if (self::$landing != self::$booking->from_icao) {
                            self::$status = Booking::STATUS_APPROACH;
                        }
                    }

                    if (self::$booking->flight->lastTrack->groundspeed <= 140 && in_array(
                            self::$booking->fleet->actypes->weightclass,
                            ['S', 'L']
                        ) && self::$landing && self::$status == Booking::STATUS_ENROUTE
                    ) {
                        if (self::$landing != self::$booking->from_icao) {
                            self::$status = Booking::STATUS_APPROACH;
                        }
                    }

                    if (self::$booking->flight->landing && self::$status = Booking::STATUS_APPROACH) {
                        self::$status = Booking::STATUS_LANDED;
                    }
                }

                break;

            case Booking::BOOKING_FLIGHT_END:
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
                break;

            case Booking::BOOKING_DELETED_BY_USER:
                self::$status = Booking::STATUS_CANCELED;
                break;
        }
    }

    public static function get($booking, $landing = false)
    {
        try {
            self::$booking = $booking;
            self::$landing = $landing;
            self::check();
            self::save();

        } catch (\Exception $ex) {
            var_dump($ex);
        }
    }
} 