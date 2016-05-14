<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 30.09.15
 * Time: 22:29
 */
namespace app\commands;

use app\components\Helper;
use app\components\Slack;
use app\models\Actypes;
use app\models\Airports;
use app\models\Billing;
use app\models\Booking;
use app\models\Fleet;
use app\models\Flights;
use app\models\Pax;
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
    const WZ_FPL_SPD = 10;
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
    const WZ_FLIGHT_RULES = 21;
    const WZ_FLIGHT_TYPE = 43;
    const WZ_AIRCRAFT = 9;
    const WZ_DEPTIME = 22;

    const MAX_DISTANCE_TO_SAVE_FLIGHT = 10;
    const HOLD_TIME = 10;

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
     * Отправлять или не отправлять, вот в чём вопрос.
     * @var bool
     */
    private $slackFeed = true;

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
     * @return bool|string
     */
    private function validateFlight($flight)
    {
        $airports = [
            $flight->to_icao => Airports::find()->andWhere(['icao' => $flight->to_icao])->one(),
            $flight->from_icao => Airports::find()->andWhere(['icao' => $flight->from_icao])->one(),
            $flight->alternate1 => Airports::find()->andWhere(['icao' => $flight->alternate1])->one(),
            $flight->alternate2 => Airports::find()->andWhere(['icao' => $flight->alternate2])->one(),
        ];

        $tracker = Tracker::find()->andWhere(['user_id' => $flight->user_id])->orderBy('dtime desc')->one();

        foreach ($airports as $name => $airport) {
            if (Helper::calculateDistanceLatLng($tracker->latitude, $airport->lat, $tracker->longitude, $airport->lon)
                < self::MAX_DISTANCE_TO_SAVE_FLIGHT
            ) {
                return $name;
            }
        }

        return false;

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

        $flight->acf_type = Fleet::find()->andWhere(['id'=>$flight->fleet_regnum])->one()->type_code;
        $flight->id = $booking->id;
        $flight->user_id = $booking->user_id;
        $flight->status = Flights::FLIGHT_STATUS_STARTED;
        $flight->first_seen = gmdate('Y-m-d H:i:s');
        $flight = $this->updateData($flight);
        $paxs=Pax::appendPax($flight->from_icao,$flight->to_icao,$flight->fleet,true);
        $flight->pob = $paxs['total'];
        $flight->paxtypes = serialize($paxs['paxtypes']);

        if ($flight->save()) {
            $booking->status = Booking::BOOKING_FLIGHT_START;
            $booking->save();

            if ($this->slackFeed) {
                $slack = new Slack('#dev_reports', "Flight {$booking->callsign} - {$booking->from_icao} - {$booking->to_icao}, Pilot - {$booking->user_id} started with {$paxs['total']} pax on board.");
                $slack->sent();
            }
        }
        else{
            var_dump($flight->errors);
        }
    }



    /**
     * Обновляет полеты, или заверщшает их в зависимости от наличия в вазапе
     */
    private function updateFlights()
    {
        foreach (Flights::find()->andWhere(['status' => Flights::FLIGHT_STATUS_STARTED])->all() as $flight) {
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
        $booking = Booking::find()->andWhere(['id' => $flight->id])->one();
        $booking->status = Booking::BOOKING_FLIGHT_END;
        $booking->save();

        if ($landing = $this->validateFlight($flight)) {
            $flight->last_seen = gmdate('Y-m-d H:i:s');
            $flight->status = Flights::FLIGHT_STATUS_OK;
            $flight->flight_time = intval((strtotime($flight->landing_time) - strtotime($flight->dep_time))/60);
            $flight->landing = $landing;

            $this->transferPilot($flight, $landing);
            $this->transferCraft($flight, $landing);
            //Биллинг

            $flight->vucs = Billing::calculatePriceForFlight($flight->from_icao,$flight->landing,unserialize($flight->paxtypes));
            Billing::doFlightCosts($flight);

            if ($this->slackFeed) {
                $slack = new Slack('#dev_reports', "Flight {$booking->callsign} - {$booking->from_icao} - {$booking->to_icao}, Pilot - {$booking->user_id} finished in {$landing}.");
                $slack->addText($flight->fpl);
                $slack->sent();
            }
        } else {
            if ((gmmktime() - strtotime($flight->last_seen)) > self::HOLD_TIME) {
                $flight->last_seen = gmdate('Y-m-d H:i:s');
                $flight->status = Flights::FLIGHT_STATUS_BREAK;

                if ($this->slackFeed) {
                    $slack = new Slack('#dev_reports', "Flight {$booking->callsign} - {$booking->from_icao} - {$booking->to_icao}, Pilot - {$booking->user_id} failed.");
                    $slack->addText($flight->fpl);
                    $slack->sent();
                }
            }
        }

        $flight->save();
    }

    private function transferPilot($flight, $landing)
    {
        Users::transfer($flight->user_id, $landing);
    }

    private function transferCraft($flight, $landing)
    {
        Fleet::transfer($flight->fleet_regnum, $landing);
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

        $booking = Booking::find()->andWhere(['id' => $flight->id])->one();

        if ($this->validateOnlineFlight($booking, $data)){

            $flight->from_icao = $booking->from_icao;
            $flight->to_icao = $booking->to_icao;
            $flight->last_seen = gmdate('Y-m-d H:i:s');
            $flight->flightplan = $this->getFlightRoute($data);
            $flight->callsign = $data[self::WZ_CALLSIGN];
            $flight->remarks = $data[self::WZ_REMARKS];
            $flight->fob = sprintf("%02d:%02d",$data[self::WZ_FOB_HOURS],$data[self::WZ_FOB_MINUTES]);
            //$flight->pob = $data[self::WZ_POB];
            $flight->domestic = $this->isDomestic($flight) ? 1 : 0;
            $flight->alternate1 = $data[self::WZ_ICAOALT1];
            $flight->alternate2 = $data[self::WZ_ICAOALT2];
            $flight->nm += intval(Helper::calculateDistanceLatLng($flight->lastTrack->latitude,$data[self::WZ_LATITUDE],$flight->lastTrack->longitude,$data[self::WZ_LONGITUDE]));
            $flight->sim = $data[self::WZ_SIMULATOR]; //according to ivao specifications (8-FS9, 9-FSX, 11-14 X-planes...)
            $flight->eet = sprintf("%02d:%02d",$data[self::WZ_EET_HOURS],$data[self::WZ_EET_MINUTES]);

            if ($flight->dep_time == '0000-00-00 00:00:00' && $data[self::WZ_ONGROUND] == 0 && $data[self::WZ_GROUNDSPEED] > 40) {
                $flight->dep_time = gmdate('Y-m-d H:i:s');
            }

            if ($flight->dep_time > '0000-00-00 00:00:00' && $flight->landing_time == '0000-00-00 00:00:00' && $data[self::WZ_ONGROUND] == 1 && $data[self::WZ_GROUNDSPEED] <= 40) {
                $flight->landing_time = gmdate('Y-m-d H:i:s');
            }

            $flight->fpl = $this->getFPL($data);

            $this->insertTrackerData($flight);
        }

        return $flight;
    }

    /**
     * Возвращает маршрутную часть ФПЛ.
     * @param int $int user_id для поиска в массиве с пилотами
     * @return string
     */
    private function getFlightRoute($data)
    {
        return $data[self::WZ_FPL_SPD] . $data[self::WZ_FPL_ALT] . " " . $data[self::WZ_FLIGHTPLAN];
    }

    private function getFPL($data){
        return '(FPL-'.$data[self::WZ_CALLSIGN].'-'.$data[self::WZ_FLIGHT_RULES].$data[self::WZ_FLIGHT_TYPE]."\n".
                '-'.$data[self::WZ_AIRCRAFT]."\n".
                '-'.$data[self::WZ_ICAOFROM].$data[self::WZ_DEPTIME]."\n".
                '-'.$this->getFlightRoute($data)."\n".
                '-'.$data[self::WZ_ICAOTO].sprintf("%02d%02d",$data[self::WZ_EET_HOURS],$data[self::WZ_EET_MINUTES]).' '.$data[self::WZ_ICAOALT1].' '.$data[self::WZ_ICAOALT2]."\n".
                '-'.$data[self::WZ_RMK]."\n".
                '-E/'.sprintf("%02d%02d",$data[self::WZ_FOB_HOURS],$data[self::WZ_FOB_MINUTES]).')';
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
            $booking->status == Booking::BOOKING_INIT &&
            !Flights::find()->andWhere(['id' => $booking->id])->one()
        );

    }

    private function validateOnlineFlight($booking, $data)
    {
        return (
            $booking->from_icao == $data[self::WZ_ICAOFROM] &&
            $booking->to_icao == $data[self::WZ_ICAOTO] &&
            $booking->callsign == $data[self::WZ_CALLSIGN] &&
            $booking->status == Booking::BOOKING_FLIGHT_START
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
        if ($flight->depAirport->iso == 'RU' && $flight->arrAirport->iso == 'RU') {
            return true;
        }
        return false;
    }
}