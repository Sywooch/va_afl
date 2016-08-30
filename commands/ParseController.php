<?php
namespace app\commands;

use app\components\Helper;
use app\components\IvaoWx;
use app\components\Levels;
use app\components\Slack;
use app\models\Airports;
use app\models\Billing;
use app\models\Booking;
use app\models\Fleet;
use app\models\Flights;
use app\models\Flights\Status;
use app\models\Pax;
use app\models\Tracker;
use app\models\Users;
use yii\base\Exception;
use yii\console\Controller;

/**
 * Class ParseController
 * Замечательный трекер
 * TODO: Рефактор и вынесение большой части функций для работы с данными в модели
 * TODO: Отдельный класс для разбора whazzup'a
 * @author Alexander Shakhmukhametov - написание первой версии трекера
 * @author Nikita Fedoseev - изменение и доработка функционала
 * @package app\commands
 */
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
    const HOLD_TIME = 1800;

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

        $tracker = Tracker::find()->where(['flight_id' => $flight->id])->orderBy('dtime desc')->one();
        if ($tracker) {
            foreach ($airports as $name => $airport) {
                if ($airport) {
                    if (Helper::calculateDistanceLatLng(
                            $tracker->latitude,
                            $airport->lat,
                            $tracker->longitude,
                            $airport->lon
                        )
                        < self::MAX_DISTANCE_TO_SAVE_FLIGHT
                    ) {
                        return $name;
                    }
                }
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
            Fleet::changeStatus($booking->fleet_regnum, Fleet::STATUS_ENROUTE);

            $flight->fleet_regnum = $booking->fleet_regnum;
        }

        $flight->id = $booking->id;
        $flight->user_id = $booking->user_id;
        $flight->status = Flights::FLIGHT_STATUS_STARTED;
        $flight->first_seen = gmdate('Y-m-d H:i:s');
        $flight->last_seen = gmdate('Y-m-d H:i:s');
        $paxs = Pax::appendPax($booking->from_icao, $booking->to_icao, $flight->fleet, true);
        $flight->pob = $paxs['total'];
        $flight->paxtypes = serialize($paxs['paxtypes']);

        $flight = $this->updateData($flight);

        if ($flight->save()) {
            $booking->status = Booking::BOOKING_FLIGHT_START;
            $booking->save();

            Status::get($booking, false);

            if ($this->slackFeed) {
                $slack = new Slack('#dev_reports', "Flight {$booking->callsign}({$booking->from_icao} - {$booking->to_icao}) started with {$paxs['total']} pax on board.");
                $slack->sent();
            }
        } else {
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

        if ($flight->landing) {
            $flight->finished = gmdate('Y-m-d H:i:s');
            $flight->status = Flights::FLIGHT_STATUS_OK;
            $booking->status = Booking::BOOKING_FLIGHT_END;
            $flight->flight_time = intval((strtotime($flight->landing_time) - strtotime($flight->dep_time)) / 60);

            $this->transferPilot($flight, $flight->landing);

            if($booking->fleet_regnum){
                $this->transferCraft($flight, $flight->landing);
                Fleet::changeStatus($booking->fleet_regnum, Fleet::STATUS_AVAIL);
                Fleet::checkSrv($booking->fleet_regnum, $flight->landing);
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

            //Slack
            if ($this->slackFeed) {
                $slack = new Slack('#dev_reports', "{$booking->callsign}({$booking->from_icao} - {$booking->to_icao}) finished in {$flight->landing}.");
                $slack->sent();
            }
        } else {
            if ((gmmktime() - strtotime($flight->last_seen)) > self::HOLD_TIME) {
                $flight->last_seen = gmdate('Y-m-d H:i:s');
                $flight->status = Flights::FLIGHT_STATUS_BREAK;
                $booking->status = Booking::BOOKING_FLIGHT_END;

                //Разблокировка борта
                if($booking->fleet_regnum){
                    Fleet::changeStatus($booking->fleet_regnum, Fleet::STATUS_AVAIL);
                }

                if ($this->slackFeed) {
                    $slack = new Slack('#dev_reports', "{$booking->callsign}({$booking->from_icao} - {$booking->to_icao}) failed.");
                    $slack->sent();
                }
            }
        }

        $booking->save();
        $flight->save();

        Status::get($booking, $flight->landing);
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
        $this->updateData($flight, true);
    }

    private function updateData($flight, $save = false)
    {
        $data = $this->ourpilots[$flight->user_id];

        $booking = Booking::find()->andWhere(['id' => $flight->id])->one();

        if ($this->validateOnlineFlight($booking, $data)) {

            if ($booking->fleet_regnum) {
                $time = intval((strtotime(gmdate('Y-m-d H:i:s')) - strtotime($flight->last_seen)) / 60);
                Fleet::hrsAdd($booking->fleet_regnum, $time);
            }

            $flight->from_icao = $booking->from_icao;
            $flight->to_icao = $booking->to_icao;
            $flight->acf_type = explode('/', $data[self::WZ_AIRCRAFT])[1];
            $flight->last_seen = gmdate('Y-m-d H:i:s');
            $flight->flightplan = $this->getFlightRoute($data);
            $flight->callsign = $data[self::WZ_CALLSIGN];
            $flight->remarks = $data[self::WZ_REMARKS];
            $flight->fob = sprintf("%02d:%02d", $data[self::WZ_FOB_HOURS], $data[self::WZ_FOB_MINUTES]);
            //$flight->pob = $data[self::WZ_POB];
            $flight->domestic = $this->isDomestic($flight) ? 1 : 0;
            $flight->alternate1 = $data[self::WZ_ICAOALT1];
            $flight->alternate2 = $data[self::WZ_ICAOALT2];

            if (isset($flight->lastTrack)) {
                $flight->nm += intval(
                    Helper::calculateDistanceLatLng(
                        $flight->lastTrack->latitude,
                        $data[self::WZ_LATITUDE],
                        $flight->lastTrack->longitude,
                        $data[self::WZ_LONGITUDE]
                    )
                );
            }

            $flight->sim = $data[self::WZ_SIMULATOR]; //according to ivao specifications (8-FS9, 9-FSX, 11-14 X-planes...)
            $flight->eet = sprintf("%02d:%02d", $data[self::WZ_EET_HOURS], $data[self::WZ_EET_MINUTES]);

            if ($flight->dep_time == '0000-00-00 00:00:00' && $data[self::WZ_ONGROUND] == 0 && $data[self::WZ_GROUNDSPEED] > 40) {
                $flight->dep_time = gmdate('Y-m-d H:i:s');
                $flight->metar_dep = IvaoWx::metar($flight->from_icao);
            }

            $landing = $this->validateFlight($flight);
            if ($landing) {
                if (!$flight->landing && $flight->dep_time > '0000-00-00 00:00:00'
                    && $data[self::WZ_ONGROUND] == 1 && $data[self::WZ_GROUNDSPEED] <= 160
                ) {
                    if ($this->slackFeed) {
                        $slack = new Slack('#dev_reports', "{$flight->callsign} - landed in {$landing}");
                        $slack->sent();
                    }
                    $flight->landing = $landing;
                    $flight->landing_time = gmdate('Y-m-d H:i:s');
                    $flight->metar_landing = IvaoWx::metar($landing);
                }
            } else {
                if ($flight->landing) {
                    if ($this->slackFeed) {
                        $slack = new Slack('#dev_reports', "{$flight->callsign} - left from {$flight->landing}");
                        $slack->sent();
                    }

                    $flight->landing = '';
                    $flight->landing_time = '0000-00-00 00:00:00';
                }
            }
            $flight->fpl = $this->getFPL($data, $flight);
            $this->insertTrackerData($flight);


        }
        if($save){
            $flight->save();
        }

        Status::get($booking, isset($landing) ? $landing : false);

        return $flight;
    }

    /**
     * Возвращает маршрутную часть ФПЛ.
     * @param $data
     * @return string
     */
    private function getFlightRoute($data)
    {
        return $data[self::WZ_FPL_SPD] . $data[self::WZ_FPL_ALT] . " " . $data[self::WZ_FLIGHTPLAN];
    }

    private function getFPL($data, $flight)
    {
        return '(FPL-' . $data[self::WZ_CALLSIGN] . '-' . $data[self::WZ_FLIGHT_RULES] . $data[self::WZ_FLIGHT_TYPE] . "\n" .
        '-' . $data[self::WZ_AIRCRAFT] . "\n" .
        '-' . $data[self::WZ_ICAOFROM] . $data[self::WZ_DEPTIME] . "\n" .
        '-' . $this->getFlightRoute($data) . "\n" .
        '-' . $data[self::WZ_ICAOTO] . sprintf(
            "%02d%02d",
            $data[self::WZ_EET_HOURS],
            $data[self::WZ_EET_MINUTES]
        ) . ' ' . $data[self::WZ_ICAOALT1] . ' ' . $data[self::WZ_ICAOALT2] . "\n" .
        '-' . $data[self::WZ_RMK] . "\n" .
        '-E/' . sprintf("%02d%02d", $data[self::WZ_FOB_HOURS], $data[self::WZ_FOB_MINUTES]) . ' ' .
        'P/' . sprintf("%03d", $data[self::WZ_POB]) . ')' . "\n" .
        'C/' . strtoupper($flight->user->full_name) . ')';
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
        $data = $this->ourpilots[$flight->user_id];

        if (!empty($data[self::WZ_LATITUDE]) && !empty($data[self::WZ_LONGITUDE])) {
            $tracker = new Tracker();
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