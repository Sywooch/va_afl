<?php
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\Airports;
use app\models\Fleet;
use app\models\FleetProfiles;
use app\components\internal\routes\Routes;


/**
 * Class briefing
 */
class Briefing extends Component
{
    public $routes;
    /*private $callsign;
    private $from;
    private $to;*/
    /**
     * @var Fleet
     */
    private $aircraft;
    private $template = [
        //'PBN', 'NAV', 'REG', 'OPR', 'EET', 'SEL', 'RALT', 'RMK'
        'PBN',
        'REG',
        'OPR',
        'EET',
        'SEL',
        'RALT',
        'DOF',
        'RMK',
    ];
    private $operator = 'VA AFL';
    /**
     * @var \app\models\Booking
     */
    private $booking;

    //$callsing, $from, $to,
    public function __construct($aircraft){
        /*$this->callsign = $callsing;
        $this->from = Airports::icao($from);
        $this->to = Airports::icao($to);*/
        $this->aircraft = Fleet::findOne($aircraft);
    }

    /**
     * @param \app\models\Booking $booking
     * @return $this
     */
    public static function fromBooking($booking){
        $one = new Briefing($booking->fleet_regnum ? $booking->fleet->id : null);
        $one->routes = new Routes($booking->from_icao, $booking->to_icao);
        return $one;
    }

    public function getRemarks(){
        $remarks = '';
        foreach($this->template as $part){
            if(!empty($this->$part)){
                $remarks .= $this->$part.' ';
            }
        }
        return trim($remarks);
    }

    public function getPBN(){
        return $this->aircraft ? $this->aircraft->profileInfo ? $this->aircraft->profileInfo->pbn ? 'PBN/' . $this->aircraft->profileInfo->pbn : '' : '' : '';
    }

    public function getNAV(){
        return $this->aircraft ? $this->aircraft->profileInfo ? $this->aircraft->profileInfo->nav ? 'NAV/' . $this->aircraft->profileInfo->nav : '' : '' : '';
    }

    public function getSEL(){
        return $this->aircraft ? $this->aircraft->selcal ? 'SEL/' . $this->aircraft->selcal : '' : '';
    }

    public function getRMK(){
        return $this->aircraft ? $this->aircraft->profileInfo ? $this->aircraft->profileInfo->rmk ? 'RMK/' . $this->aircraft->profileInfo->rmk : '' : '' : '';
    }

    public function getOPR(){
        return 'OPR/'.$this->operator;
    }

    public function getREG(){
        return $this->aircraft ? 'REG/' . str_replace('-', '', $this->aircraft->regnum) : '';
    }

    public function getDOF()
    {
        return 'DOF/' . date("ymd");
    }
}
