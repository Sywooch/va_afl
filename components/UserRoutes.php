<?php

namespace app\components;

use app\models\Flights;

/**
 * Class UserRoutes
 *
 * Предоставляет доступ к маршрутам пользователя
 *
 * @package app\components
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */

class UserRoutes
{
    /**
     * VID Пользователя
     * @var int
     */
    private $user_id;
    /**
     * Массив с маршуртами, как app\models\Flights
     * @var array
     */
    private $routes;

    /**
     * Конструктор
     * @param int $user_id VID пользователя
     * @return $this
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->getRoutes();
    }

    /**
     * Записывает маршруты
     */
    private function getRoutes()
    {
        $this->routes = Flights::find()->where(['user_id' => $this->user_id, 'status' => Flights::FLIGHT_STATUS_OK])->select('from_icao, to_icao')->joinWith(
            [
                'depAirport' => function ($q) {
                        $q->from('airports dep');
                    },
                'arrAirport' => function ($q) {
                        $q->from('airports arr');
                    }
            ]
        )->groupBy(
                [
                    'from_icao',
                    'to_icao'
                ]
            )->all();
    }

    /**
     * Getter для маршрутов
     * @return array
     */
    public function get()
    {
        return $this->routes;
    }

    /**
     * Возвращаем маршруты, как массив
     * @return array
     */
    public function getAsArray()
    {
        $routes = [];

        foreach ($this->get() as $route) {
            /**
             * @var Flights $route
             */
            if ($route->depAirport && $route->arrAirport) {
                $routes[] = [
                    'from' =>
                        [
                            'icao' => $route->from_icao,
                            'lat' => $route->depAirport->lat,
                            'lon' => $route->depAirport->lon
                        ],
                    'to' =>
                        [
                            'icao' => $route->to_icao,
                            'lat' => $route->arrAirport->lat,
                            'lon' => $route->arrAirport->lon
                        ]
                ];
            }
        }

        return $routes;
    }
} 