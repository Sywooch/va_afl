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
use app\models\Flights;
use app\models\Flights\Fix;
use app\models\Flights\ops\AircraftReturn;
use app\models\Flights\ops\BookingDelete;
use app\models\Flights\ops\ScheduleUpdate;
use yii\console\Controller;

use app\models\Booking;

class FlightOpsController extends Controller
{
    public function actionIndex()
    {
        $this->deleteBooking();
        $this->aircraftReturn();
        $this->aircraftUnlock();
    }

    public function actionSchedule(){
        new ScheduleUpdate();
    }

    public function actionSetUserOnFleet(){
        $counter = 0;
        foreach(Fleet::notInBase() as $aircraft){
            if($aircraft->lastFlight && $aircraft->status == Fleet::STATUS_AVAIL){
                if($aircraft->user_id != $aircraft->lastFlight->user_id){
                    $aircraft->user_id = $aircraft->lastFlight->user_id;
                    $aircraft->save();
                    $counter++;
                }
            }
        }

        echo "Fixed aicrafts count: $counter\n";
    }

    public function actionCloseFixRequest(){
        $counter = 0;

        foreach(Flights::openRequests() as $flight){
            Fix::reject($flight->id, 0);
            $counter++;
        }

        echo "Closed $counter flight fix requests";
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

    private function aircraftUnlock()
    {
        foreach (Fleet::onBase() as $aircraft) {
            $aircraft->user_id = 0;
            $aircraft->save();
        }
    }
}