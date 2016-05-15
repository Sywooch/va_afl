<?php
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\Airports;
use app\models\Fleet;
use app\models\FleetProfiles;


/**
 * Class briefing
 * @package yii\components
 */
class Briefing extends Component
{
    /*private $callsign;
    private $from;
    private $to;*/
    /**
     * @var Fleet
     */
    private $aircraft;
    private $template = [
        'PBN', 'NAV', 'REG', 'OPR', 'EET', 'SEL', 'RALT', 'RMK'
    ];
    private $operator = 'AFLGROUP';

    //$callsing, $from, $to,
    public function __construct($aircraft){
        /*$this->callsign = $callsing;
        $this->from = Airports::icao($from);
        $this->to = Airports::icao($to);*/
        $this->aircraft = Fleet::findOne($aircraft);
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
        return $this->aircraft->profileInfo->pbn ? 'PBN/'.$this->aircraft->profileInfo->pbn : '';
    }

    public function getNAV(){
        return $this->aircraft->profileInfo->nav ? 'NAV/'.$this->aircraft->profileInfo->nav : '';
    }

    public function getSEL(){
        return $this->aircraft->selcal ? 'SEL/'.$this->aircraft->selcal : '';
    }

    public function getRMK(){
        return $this->aircraft->profileInfo->rmk ? 'RMK/'.$this->aircraft->profileInfo->rmk : '';
    }

    public function getOPR(){
        return 'OPR/'.$this->operator;
    }

    public function getREG(){
        return 'REG/'.str_replace('-', '', $this->aircraft->regnum);
    }
}
