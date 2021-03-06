<?php

namespace app\models;

use app\components\Helper;
use Yii;
use yii\base\Exception;

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

    public function getPriceType(){
        return $this->getLocale('price_type_ru', 'price_type');
    }

    /**
     * Возвращает переменную взависимости от языка
     * @param $ru string
     * @param $en string
     * @return string
     */
    private function getLocale($ru, $en)
    {
        return Yii::$app->language == 'RU' ? $this->$ru : $this->$en;
    }

    //TODO: Продумать алгоритм при посадке не в аэропорту назначения
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
        $cost = $flight->vucs;
        $results = 0;
        foreach (self::find()->where('id > 25')->andWhere('id < 56')->all() as $bi) {
            $bc = new BillingPayments();
            $bc->direction = 2;
            $bc->user_id = 0;
            $bc->flight_id = $flight->id;
            $bc->bill_cost_id = $bi->id;
            $bc->payment = $bi->base_cost * $cost;
            $bc->dtime = gmdate('Y-m-d H:i:s');
            $results += $bc->payment;

            if (in_array($bi->id, [38, 40])) {
                $bc->user_id = $flight->user_id;
                BillingUserBalance::addMoney($bc->user_id, $flight->id, $bc->payment, $bi->id);
            }else{
                $bc->save();
            }
        }

        //Выплаты компании
        try {
            BillingUserBalance::addMoney(0, $flight->id, $cost - $results, 0);
        } catch (Exception $ex) {
            throw new Exception(sprintf('Unable to make payments to company from %d flight', $flight->flight_id), 0, $ex);
        }
    }
}
