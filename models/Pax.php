<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pax".
 *
 * @property integer $id
 * @property string $from_icao
 * @property string $to_icao
 * @property integer $waiting_hours
 * @property integer $num_pax
 * @property string $created
 * @property string $updated
 */
class Pax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['waiting_hours', 'num_pax'], 'integer'],
            [['from_icao', 'to_icao'], 'string', 'max' => 4],
            [['created', 'updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_icao' => 'From Icao',
            'to_icao' => 'To Icao',
            'waiting_hours' => 'Waiting Hours',
            'num_pax' => 'Num Pax',
        ];
    }

    public function getFromport()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'from_icao']);
    }

    public function getToport()
    {
        return $this->hasOne(Airports::className(), ['icao' => 'to_icao']);
    }

    public static function getPaxListForAirport($icao)
    {
        $data = [];
        foreach (self::find()->select('
        (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end) as waiting_hours,
        sum(num_pax) as num_pax'
        )
                     ->where(['from_icao' => Users::getAuthUser()->pilot->location])->andWhere(['to_icao' => $icao])
                     ->groupBy('
       (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end)')
                     ->orderBy('num_pax desc')->all() as $p) {
            $data[$p['waiting_hours']] = $p['num_pax'];
        }
        foreach (self::find()->select('
        (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end) as waiting_hours,
        sum(num_pax) as num_pax'
                 )
                     ->where(['to_icao' => Users::getAuthUser()->pilot->location])->andWhere(['from_icao' => $icao])
                     ->groupBy('
       (case
            when waiting_hours<4 then 0
            when waiting_hours<24 then 1
            else 2
        end)')
                     ->orderBy('num_pax desc')->all() as $p) {
            $data[$p['waiting_hours'] + 3] = $p['num_pax'];
        }

        return $data;
    }

    public static function getAirportsList()
    {
        $data = [];
        foreach (self::find()->select('to_icao')->distinct(true)->where(['from_icao' => Users::getAuthUser()->pilot->location])->all() as $apt) {
            $data[] = [
                'lat' => $apt->toport->lat,
                'lon' => $apt->toport->lon,
                'name' => $apt->to_icao,
                'paxlist' => self::getPaxListForAirport($apt->to_icao)
            ];
        }
        return $data;
    }

    private static function getFeeling($paxlist)
    {
        $max = 0;
        $res = 0;
        $feeling=['green','orange','red'];
        foreach($paxlist as $k=>$v)
        {
            if($v>$max){
                $max=$v;
                $res = $k;
            }
        }
        if($res >= 3){
            $res = $res - 3;
        }
        return $feeling[$res];
    }

    public static function jsonMapData()
    {
        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        $user = Users::getAuthUser();
        foreach (self::getAirportsList() as $adata) {
            $paxlist = self::getPaxListForAirport($adata['name']);
            $data['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'name'=>$adata['name'],
                    'paxlist'=>$paxlist,
                    'feeling' => (Airports::findOne(['icao' => $adata['name']])->focus == 1 ? 'white' : self::getFeeling($paxlist)),
                    'focus' => Airports::findOne(['icao' => $adata['name']])->focus,
                    'bookthis'=>$adata['name']==$user->pilot->location?
                        '<em>'.Yii::t('booking','You are here').'</em>':
                        '<button onclick=\'smartbooking("'.$adata['name'].'");\'>'.Yii::t('booking','Book this').'</button>',
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$adata['lon'], $adata['lat']],
                ],
            ];
        }
        return json_encode($data);
    }

    public static function jsonMapDataNew()
    {
        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        $user = Users::getAuthUser();
        foreach (self::getAirportsList() as $adata) {
            $paxlist = self::getPaxListForAirport($adata['name']);
            $data['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'name'=>$adata['name'],
                    'paxlist'=>$paxlist,
                    'feeling'=>self::getFeeling($paxlist),
                    'bookthis'=>$adata['name']==$user->pilot->location?
                        '<em>'.Yii::t('booking','You are here').'</em>':
                        '<button onclick=\'smartbooking("'.$adata['name'].'");\'>'.Yii::t('booking','Book this').'</button>',
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$adata['lon'], $adata['lat']],
                ],
            ];
        }
        return json_encode($data);
    }

    public static function detailList($airport,$paxtype)
    {
        switch($paxtype){
            case 0:
                $pt = "waiting_hours < 4";
                $color = 'green';
                break;
            case 1:
                $pt = "waiting_hours between 4 and 23";
                $color = 'orange';
                break;
            case 2:
                $pt = "waiting_hours >= 24";
                $color = 'red';
                break;
        }
        $user=Users::getAuthUser();

        $html = "<span class='pull-right' style='cursor: pointer;' onClick='closedrilldown()'>&times;</span><h2 class='text-center' style='color: white;'>".$airport." <i class='fa fa-user' style='color: $color'></i></h2>";
        $html.="<div style='overflow-y: scroll; max-height: 200px;'>";
        foreach(self::find()->select('to_icao,sum(num_pax) as num_pax')
                    ->andWhere($pt)
                    ->andWhere('from_icao = "'.Users::getAuthUser()->pilot->location.'"')
                    ->andWhere('to_icao = "'.$airport.'"')
                    ->groupBy('to_icao')
                    ->all() as $data) {
            $smartbooking = ($user->pilot->location == $airport) ?
                "<a href='javascript:;' onclick='smartbooking(\"".$data->to_icao."\")'>".Yii::t('booking','Book this') ."</a>":
                "";
            $html.="<b>".$data->to_icao."</b>: ".$data->num_pax.". $smartbooking<br>";
        }
        $html.="</div>";
        return $html;
    }
    public static function appendPax($from,$to,$fleet,$need_save_pax=false)
    {
        $maxpax = $fleet ? $fleet->max_pax : 100;
        $paxtypes=['red'=>0,'yellow'=>0,'green'=>0];
        $flightpax = $maxpax;
        $needpax = self::find()->andWhere('from_icao = "'.$from.'"')->andWhere('to_icao = "'.$to.'"')->orderBy('waiting_hours desc')->all();

        foreach($needpax as $px)
        {
            if($px->num_pax <= $flightpax)
            {
                if($px->waiting_hours>=24)
                    $paxtypes['red']+=$px->num_pax;
                elseif($px->waiting_hours>4)
                    $paxtypes['yellow']+=$px->num_pax;
                else
                    $paxtypes['green']+=$px->num_pax;
                $flightpax-=$px->num_pax;
                $px->num_pax = 0;
            }
            else{
                if($px->waiting_hours>=24)
                    $paxtypes['red']+=$flightpax;
                elseif($px->waiting_hours>4)
                    $paxtypes['yellow']+=$flightpax;
                else
                    $paxtypes['green']+=$flightpax;
                $px->num_pax-=$flightpax;
                $flightpax = 0;
            }
            if($need_save_pax)$px->save();
            if($flightpax <= 0) break;
        }
        Yii::trace(['total'=>($maxpax-$flightpax),'paxtypes'=>$paxtypes]);
        return ['total'=>($maxpax-$flightpax),'paxtypes'=>$paxtypes];
    }
}
