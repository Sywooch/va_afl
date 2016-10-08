<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 09.10.16
 * Time: 0:54
 */

namespace app\models\Flights\ops;


use app\models\Booking;
use app\models\Fleet;
use app\models\Services\notifications\FlightOps;

class BookingDelete {
    /**
     * @var Booking
     */
    private $booking;

    /**
     * Construct
     * @param Booking $booking
     */
    public function __construct(Booking $booking){
        $this->booking = $booking;
        FlightOps::bookingDelete($booking);
        $this->fleet();
        $this->booking();
    }

    private function fleet(){
        if($this->booking->fleet){
            $this->booking->fleet->status = Fleet::STATUS_AVAIL;
            $this->booking->fleet->save();
        }
    }

    private function booking(){
        $this->booking->status = Booking::BOOKING_DELETED_BY_USER;
        $this->booking->g_status = Booking::STATUS_CANCELED_BY_COMPANY;
        $this->booking->save();
    }
} 