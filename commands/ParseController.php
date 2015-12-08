<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 30.09.15
 * Time: 22:29
 */
namespace app\commands;

use app\components\Helper;
use app\models\Airports;
use app\models\Booking;
use app\models\Flights;
use app\models\Tracker;
use app\models\Users;
use yii\console\Controller;

class ParseController extends Controller
{
    //Константы. В основном относятся к вазап файлу
    const WZ_VID = 1;
    const WZ_CALLSIGN = 0;
    const WZ_ICAOTO = 13;
    const WZ_ICAOFROM = 11;
    const WZ_FLIGHTPLAN = 30;
    const WZ_FOB_HOURS =26;
    const WZ_FOB_MINUTES =27;
    const WZ_POB = 44;
    const WZ_ALTITUDE = 7;
    const WZ_LATITUDE = 5;
    const WZ_LONGITUDE = 6;
    const WZ_HEADING = 45;
    const WZ_GROUNDSPEED = 8;
    const MAX_DISTANCE_TO_SAVE_FLIGHT = 10;
    const HOLD_TIME = 900;

    public $whazzupdata;
    public $ourpilots;
    public $onlinepilotslist;


    /**
     *Главная функция, запускает остальные функции
     */
    public function actionIndex()
    {
        $this->prepareWhazzup();
        $this->parseWhazzup();
        $this->bookingToFlights();
        $this->updateFlights();

    }

    /**
     *Забирает вазап файл
     */
    public function prepareWhazzup()
    {
        $this->whazzupdata = Helper::getWhazzup();
    }

    /**
     * Парсит вазап файл
     */
    public function parseWhazzup()
    {
        foreach(explode("\n",$this->whazzupdata) as $line)
        {
           if(preg_match('/PILOT/',$line))
              $this->appendOurPilots($line);
        }
    }

    /**
     * Начинает полеты по букингу, если они указаны в вазапе
     */
    public function bookingToFlights()
    {
        foreach(Booking::find()->andWhere(['user_id'=>$this->onlinepilotslist])->all() as $booking)
        {
            if($this->validateBooking($booking,$this->ourpilots[$booking->user_id]))
            {
                $this->startFlight($booking);
            }
        }
    }

    /**
     * Обновляет полеты, или заверщшает их в зависимости от наличия в вазапе
     */
    public function updateFlights()
    {
        foreach(Flights::find()->andWhere(['status'=>1])->all() as $flight)
        {
            if(empty($this->onlinepilotslist) || !in_array($flight->user_id,$this->onlinepilotslist))
                $this->endFlight($flight);
            else
                $this->updateFlightInformation($flight);
        }
    }

    /**
     * Завершает полет, удаляет букинг. Если полет невалидирован и прошло больше положенного времени- удаляет полет.
     * @param $flight
     */
    private function endFlight($flight)
    {
        $booking = Booking::find()->andWhere(['id'=>$flight->booking_id]);
        $booking->delete();
        if($this->validateFlight($flight))
        {
            $flight->lastseen = gmdate('Y-m-d H:i:s');
            $flight->status = 2;
            $flight->save();
        }
        else{
            if((gmmktime()-strtotime($flight->lastseen)) > self::HOLD_TIME)
            $flight->delete();
        }
    }

    /**
     * Валидирует полет. Проверяет, что он завершен в радиусе 10 морских миль от аэродрома назначения.
     * @param $flight
     * @return bool
     */
    private function validateFlight($flight)
    {
        $airport = Airports::find()->andWhere(['icao'=>$flight->to_icao])->one();
        $tracker = Tracker::find()->andWhere(['user_id'=>$flight->user_id])->orderBy('dtime desc')->one();
        return (Helper::calculateDistanceLatLng($tracker->latitude,$airport->lat,$tracker->longitude,$airport->lon)<self::MAX_DISTANCE_TO_SAVE_FLIGHT);
    }

    /**
     * Обновляет данные о полете и вставляет запись в трекер
     * @param $flight
     */
    private function updateFlightInformation($flight)
    {
        $data = $this->ourpilots[$flight->user_id];
        $flight->lastseen = gmdate('Y-m-d H:i:s');
        $flight->flightplan = $data[self::WZ_FLIGHTPLAN];
        $flight->fob = $data[self::WZ_FOB_HOURS].$data[self::WZ_FOB_MINUTES];
        $flight->pob = $data[self::WZ_POB];
        $flight->save();
        $this->insertTrackerData($flight);

    }

    /**
     * Записывает полетные данные в трекер
     * @param $flight
     */
    private function insertTrackerData($flight)
    {
        $tracker = new Tracker();
        $data = $this->ourpilots[$flight->user_id];
        $tracker->user_id = $flight->user_id;
        $tracker->altitude = $data[self::WZ_ALTITUDE];
        $tracker->latitude = $data[self::WZ_LATITUDE];
        $tracker->longitude = $data[self::WZ_LONGITUDE];
        $tracker->heading = $data[self::WZ_HEADING];
        $tracker->groundspeed = $data[self::WZ_GROUNDSPEED];
        $tracker->flight_id = $flight->id;
        $tracker->dtime = gmdate('Y-m-d H:i:s');
        $tracker->save();
    }

    /**
     * Начинает полет
     * @param $booking
     */
    private function startFlight($booking)
    {
        $flight = new Flights();
        if($booking->fleet_regnum)$flight->fleet_regnum = $booking->fleet_regnum;
        $flight->acf_type = $booking->aircraft_type;
        $flight->booking_id = $booking->id;
        $flight->first_seen = gmdate('Y-m-d H:i:s');
        $flight->lastseen = gmdate('Y-m-d H:i:s');
        $flight->flightplan = $this->ourpilots[$booking->user_id][self::WZ_FLIGHTPLAN];
        $flight->fob = $this->ourpilots[$booking->user_id][self::WZ_FOB_HOURS].$this->ourpilots[$booking->user_id][self::WZ_FOB_MINUTES];
        $flight->pob = $this->ourpilots[$booking->user_id][self::WZ_POB];
        $flight->from_icao = $booking->from_icao;
        $flight->to_icao = $booking->to_icao;
        $flight->user_id = $booking->user_id;
        $flight->status = 1;
        if($flight->save()){
            $booking->status = 2;
            $booking->save();
        }

    }

    /**
     * Валидирует букинг в онлайне.
     * @param $booking
     * @param $data
     * @return bool
     */
    private function validateBooking($booking,$data)
    {
        return (
            $booking->from_icao == $data[self::WZ_ICAOFROM] &&
            $booking->to_icao == $data[self::WZ_ICAOTO] &&
            $booking->callsign == $data[self::WZ_CALLSIGN] &&
            $booking->status == 1 &&
            !Flights::find()->andWhere(['booking_id'=>$booking->id])->one()
        );

    }

    /**
     * Проверяет по вазапу, не наш ли это пилот, и если наш - добавляет в массив наших пилотов в онлайне.
     * @param $line
     */
    private function appendOurPilots($line)
    {
        $data = explode(":",$line);
        if(Users::find()->andWhere(['vid'=>$data[self::WZ_VID]])->one())
        {
            $this->ourpilots[$data[self::WZ_VID]]=$data;
            $this->onlinepilotslist[]=$data[self::WZ_VID];
        }
    }
}