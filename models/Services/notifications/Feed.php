<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 12.12.2016
 * Time: 13:14
 */

namespace app\models\Services\notifications;

use app\models\Content;

class Feed
{
    const TEMPLATE_TOUR_START = 6187;
    const TEMPLATE_TOUR_END = 6188;

    const CONTENT_CATEGORY_TOURS = 50;

    /**
     * @param $data array
     * @param $user_id int
     */
    public static function tourStart($data, $user_id)
    {
        Content::template(self::TEMPLATE_TOUR_START, $data, self::CONTENT_CATEGORY_TOURS, $user_id);
    }

    /**
     * @param $data array
     * @param $user_id int
     */
    public static function tourEnd($data, $user_id)
    {
        Content::template(self::TEMPLATE_TOUR_END, $data, self::CONTENT_CATEGORY_TOURS, $user_id);
    }
}