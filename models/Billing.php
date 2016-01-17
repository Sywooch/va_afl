<?php

namespace app\models;

use app\components\Helper;
use Yii;

/**
 * This is the model class for table "billing".
 *
 * @property integer $id
 * @property string $price_type
 * @property double $base_cost
 * @property string $comment
 */
class Billing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['base_cost'], 'number'],
            [['comment'], 'string'],
            [['price_type'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_type' => 'Price Type',
            'base_cost' => 'Base Cost',
            'comment' => 'Comment',
        ];
    }

    public static function calculatePriceForFlight($from,$to,$paxlist)
    {
        $afrom = Airports::find()->andWhere(['icao'=>$from])->one();
        $ato = Airports::find()->andWhere(['icao'=>$to])->one();
        $distance = Helper::calculateDistanceLatLng($afrom->lat,$ato->lat,$afrom->lon,$ato->lon);
        $tprice = 0;
        $ids = ['red'=>3,'yellow'=>2,'green'=>1];
        foreach($paxlist as $key=>$val)
        {
            $k=self::findOne($ids[$key])->base_cost;
            $tprice+=$k*$val*$distance;
        }
        return sprintf("%.02f",$tprice);
    }

    public static function doFlightCosts($flight)
    {
        $cost=$flight->vucs;
        $results = 0;
        foreach(self::find()->andWhere('id > 25')->all() as $bi)
        {
            $bc = new BillingPayments();
            $bc->direction='outbound';
            $bc->user_id=$flight->user_id;
            $bc->flight_id=$flight->user_id;
            $bc->bill_cost_id = $bi->id;
            $bc->payment=$bi->base_cost*$cost;
            $bc->dtime = gmdate('Y-m-d H:i:s');
            $bc->save();
            $results+=$bc->payment;
            //Зарплата пилота
            if(in_array($bi->id,[38,40]))
            {
                if(!$ub=BillingUserBalance::find()->andWhere(['user_vid'=>$bc->user_id])->one())
                    $ub=new BillingUserBalance();
                $ub->balance+=$bc->payment;
                $ub->lastupdate=date('Y-m-d H:i:s');
                $ub->save();
            }
        }
        //Выплаты компании
        $bc = new BillingPayments();
        $bc->direction='inbound';
        $bc->user_id=$flight->user_id;
        $bc->flight_id=$flight->user_id;
        $bc->bill_cost_id = 0;
        $bc->payment=$cost-$results;
        $bc->dtime = gmdate('Y-m-d H:i:s');
        $bc->save();
        $ub=BillingUserBalance::find()->andWhere(['user_vid'=>0])->one();
        $ub->balance+=$bc->payment;
        $ub->lastupdate=date('Y-m-d H:i:s');
        $ub->save();
    }
}
