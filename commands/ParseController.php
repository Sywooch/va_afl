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
use app\models\Fleet;
use app\models\Flights;
use app\models\Tracker;
use app\models\UserPilot;
use app\models\Users;
use yii\console\Controller;

class ParseController extends Controller
{
    //Константы. В основном относятся к вазап файлу
    const WZ_CALLSIGN = 0;
    const WZ_VID = 1;
    const WZ_LATITUDE = 5;
    const WZ_LONGITUDE = 6;
    const WZ_ALTITUDE = 7;
    const WZ_GROUNDSPEED = 8;
    const WZ_FPL_SPD = 9;
    const WZ_ICAOFROM = 11;
    const WZ_FPL_ALT = 12;
    const WZ_ICAOTO = 13;
    const WZ_EET_HOURS = 24;
    const WZ_EET_MINUTES = 25;
    const WZ_FOB_HOURS = 26;
    const WZ_FOB_MINUTES = 27;
    const WZ_ICAOALT1 = 28;
    const WZ_RMK = 29;
    const WZ_FLIGHTPLAN = 30;
    const WZ_ICAOALT2 = 42;
    const WZ_POB = 44;
    const WZ_HEADING = 45;
    const WZ_SIMULATOR = 47;
    const WZ_ONGROUND = 46;
    const WZ_REMARKS = 29;
    const WZ_ALTERNATE = 28;
    const MAX_DISTANCE_TO_SAVE_FLIGHT = 10;
    const HOLD_TIME = 900;
    const FLIGHT_STATUS_OK = 2;
    const FLIGHT_STATUS_BREAK = 3;
    const FLIGHT_STATUS_STARTED = 1;

    /**
     * Whazzup
     * @var string
     */
    private $whazzupdata;
    /**
     * Массив с данными о полёте наших полётов
     * @var array
     */
    private $ourpilots;

    /**
     * Массив с VID всех наших пилотов онлайн
     * @var array
     */
    private $onlinepilotslist;

    /**
     * Главная функция, запускает остальные функции
     */
    public function actionIndex()
    {
        $this->prepareWhazzup();
        $this->parseWhazzup();
        $this->bookingToFlights();
        $this->updateFlights();
    }

    /**
     * Забирает вазап файл
     */
    private function prepareWhazzup()
    {
        $this->whazzupdata = Helper::getWhazzup();
    }

    /**
     * Парсит вазап файл
     */
    private function parseWhazzup()
    {
        foreach (explode("\n", $this->whazzupdata) as $line) {
            if (preg_match('/PILOT/', $line)) {
                $this->appendOurPilots($line);
            }
        }
    }

    /**
     * Начинает полеты по букингу, если они указаны в вазапе
     */
    private function bookingToFlights()
    {
        foreach (Booking::find()->andWhere(['user_id' => $this->onlinepilotslist])->all() as $booking) {
            if ($this->validateBooking($booking, $this->ourpilots[$booking->user_id])) {
                $this->startFlight($booking);
            }
        }
    }

    /**
     * Валидирует полет. Проверяет, что он завершен в радиусе MAX_DISTANCE от аэродрома назначения.
     * @param $flight
     * @return bool
     */
    private function validateFlight($flight)
    {
        $airport = Airports::find()->andWhere(['icao' => $flight->to_icao])->one();
        $tracker = Tracker::find()->andWhere(['user_id' => $flight->user_id])->orderBy('dtime desc')->one();
        return (Helper::calculateDistanceLatLng(
                $tracker->latitude,
                $airport->lat,
                $tracker->longitude,
                $airport->lon
            ) < self::MAX_DISTANCE_TO_SAVE_FLIGHT);
    }

    /**
     * Начинает полет
     * @param $booking
     */
    private function startFlight($booking)
    {
        $flight = new Flights();
        if ($booking->fleet_regnum) {
            $flight->fleet_regnum = $booking->fleet_regnum;
        }
        $flight->acf_type = $booking->aircraft_type;
        $flight->booking_id = $booking->id;
        $flight->user_id = $booking->user_id;
        $flight->status = self::FLIGHT_STATUS_STARTED;
        $flight->first_seen = gmdate('Y-m-d H:i:s');
        $flight = $this->updateData($flight);
        if ($flight->save()) {
            $booking->status = 2;
            $booking->save();
        }
    }

    /**
     * Обновляет полеты, или заверщшает их в зависимости от наличия в вазапе
     */
    private function updateFlights()
    {
        foreach (Flights::find()->andWhere(['status' => 1])->all() as $flight) {
            if (empty($this->onlinepilotslist) || !in_array($flight->user_id, $this->onlinepilotslist)) {
                $this->endFlight($flight);
            } else {
                $this->updateFlightInformation($flight);
            }
        }
    }

    /**
     * Завершает полет, удаляет букинг. Если полет невалидирован и прошло больше положенного времени- удаляет полет.
     * @param $flight
     */
    private function endFlight($flight)
    {
        $booking = Booking::find()->andWhere(['id' => $flight->booking_id])->one();
        $booking->delete();
        if ($this->validateFlight($flight)) {
            $flight->last_seen = gmdate('Y-m-d H:i:s');
            $flight->status = self::FLIGHT_STATUS_OK;
            $flight->save();
            $this->transferPilot($flight);
            $this->transferCraft($flight);
        } else {
            if ((gmmktime() - strtotime($flight->last_seen)) > self::HOLD_TIME) {
                $flight->last_seen = gmdate('Y-m-d H:i:s');
                $flight->status = self::FLIGHT_STATUS_BREAK;
                $flight->save();
            }
        }
        $up = UserPilot::findOne($flight->user_id);
        $up->minutes = (strtotime($flight->landing_time) - strtotime($flight->dep_time))*60;
        $up->save();
    }

    /**
     * Перемещает пилота
     * @param $flight
     */
    private function transferPilot($flight)
    {
        Users::transfer($flight->user_id, $flight->to_icao);
    }

    /**
     * Перемещает борт
     * @param $flight
     */
    private function transferCraft($flight)
    {
        Fleet::transfer($flight->fleet_regnum, $flight->to_icao);
    }

    /**
     * Обновляет данные о полете и вставляет запись в трекер
     * @param $flight
     */
    private function updateFlightInformation($flight)
    {
        $flight = $this->updateData($flight);
        $flight->save();
    }

    private function updateData($flight)
    {
        $data = $this->ourpilots[$flight->user_id];
        $booking = Booking::find()->andWhere(['id' => $flight->booking_id])->one();
        $flight->from_icao = $booking->from_icao;
        $flight->to_icao = $booking->to_icao;
        $flight->last_seen = gmdate('Y-m-d H:i:s');
        $flight->flightplan = $data[self::WZ_FLIGHTPLAN];
        $flight->callsign = $data[self::WZ_CALLSIGN];
        $flight->remarks = $data[self::WZ_REMARKS];
        $flight->fob = sprintf("%02d:%02d",$data[self::WZ_FOB_HOURS],$data[self::WZ_FOB_MINUTES]);
        $flight->pob = $data[self::WZ_POB];
        $flight->domestic = $this->isDomestic($flight) ? 1 : 0;
        $flight->alternate1 = $data[self::WZ_ALTERNATE];
        $flight->nm = intval(Helper::calculateDistanceLatLng($flight->depAirport->lat,$flight->arrAirport->lat,$flight->depAirport->lon,$flight->arrAirport->lon));
        $flight->sim = $data[self::WZ_SIMULATOR]; //according to ivao specifications (8-FS9, 9-FSX, 11-14 X-planes...)
        $flight->eet = sprintf("%02d:%02d",$data[self::WZ_EET_HOURS],$data[self::WZ_EET_MINUTES]);
        if($flight->dep_time=='0000-00-00 00:00:00' && $data[self::WZ_ONGROUND]==0 && $data[self::WZ_GROUNDSPEED]>40) $flight->dep_time=gmdate('Y-m-d H:i:s');
        if($flight->dep_time>'0000-00-00 00:00:00' && $data[self::WZ_ONGROUND]==1 && $data[self::WZ_GROUNDSPEED]<=40) $flight->landing_time=gmdate('Y-m-d H:i:s');
        $this->insertTrackerData($flight);
        return $flight;
    }

    /**
     * Возвращает маршрутную часть ФПЛ.
     * @param int $int user_id для поиска в массиве с пилотами
     * @return string
     */
    private function getFlightRoute($user_id)
    {
        return $this->ourpilots[$user_id][self::WZ_FPL_SPD] . $this->ourpilots[$user_id][self::WZ_FPL_ALT] . " " . $this->ourpilots[$user_id][self::WZ_FLIGHTPLAN];
    }

    /**
     * Валидирует букинг в онлайне.
     * @param $booking
     * @param $data
     * @return bool
     */
    private function validateBooking($booking, $data)
    {
        return (
            $booking->from_icao == $data[self::WZ_ICAOFROM] &&
            $booking->to_icao == $data[self::WZ_ICAOTO] &&
            $booking->callsign == $data[self::WZ_CALLSIGN] &&
            $booking->status == 1 &&
            !Flights::find()->andWhere(['booking_id' => $booking->id])->one()
        );

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
     * Проверяет по вазапу, не наш ли это пилот, и если наш - добавляет в массив наших пилотов в онлайне.
     * @param $line
     */
    private function appendOurPilots($line)
    {
        $data = explode(":", $line);
        if (Users::find()->andWhere(['vid' => $data[self::WZ_VID]])->one()) {
            $this->ourpilots[$data[self::WZ_VID]] = $data;
            $this->onlinepilotslist[] = $data[self::WZ_VID];
        }
    }

    private function isDomestic($flight)
    {
        if ($flight->depAirport->country == 'ru' && $flight->arrAirport->country == 'ru') {
            return true;
        }
        return false;
    }
}