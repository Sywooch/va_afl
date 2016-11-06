<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 06.01.16
 * Time: 14:40
 *
 * Запуск из крона каждый час
 *
 */
namespace app\commands;

use app\models\Fleet;
use app\models\Flights\ops\AircraftReturn;
use app\models\Flights\ops\BookingDelete;
use yii\console\Controller;

use app\models\Booking;

class FlightOpsController extends Controller
{
    public function actionIndex()
    {
        $this->deleteBooking();
        $this->aircraftReturn();
    }

    private function deleteBooking()
    {
        foreach(Booking::toDelete() as $book){
            new BookingDelete($book);
        }
    }

    private function aircraftReturn(){
        foreach(Fleet::notInBase() as $aircraft){
            if($aircraft->lastFlight && $aircraft->status == Fleet::STATUS_AVAIL){
                new AircraftReturn($aircraft->lastSuccessFlight);
            }
        }
    }
}