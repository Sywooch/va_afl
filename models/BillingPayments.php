<?php

namespace app\models;

use Yii;
use yii\web\HttpException;

/**
 * This is the model class for table "billing_payments".
 *
 * @property integer $id
 * @property integer $direction
 * @property integer $user_id
 * @property integer $flight_id
 * @property integer $bill_cost_id
 * @property double $payment
 * @property string $dtime
 */
class BillingPayments extends \yii\db\ActiveRecord
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBilling()
    {
        return $this->hasOne(Billing::className(), ['id' => 'bill_cost_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing_payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'direction', 'user_id', 'flight_id', 'bill_cost_id'], 'integer'],
            [['payment'], 'number'],
            [['dtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direction' => 'Direction',
            'user_id' => 'User ID',
            'flight_id' => 'Flight ID',
            'bill_cost_id' => 'Bill Cost ID',
            'payment' => 'Payment',
            'dtime' => 'Dtime',
        ];
    }
    public static function registerPayment($direction,$user_id,$flight_id,$bcost_id,$payment)
    {
        $bc = new BillingPayments();
        $bc->direction=$direction;
        $bc->user_id=$user_id;
        $bc->flight_id=$flight_id;
        $bc->bill_cost_id=$bcost_id;
        $bc->payment=$payment;
        $bc->dtime=date('Y-m-d H:i:s');
        if(!$bc->save()) {
            throw new HttpException(500, json_encode($bc->errors));
        }
    }
    public static function registerTaxiPayment($user_id,$payment)
    {
        self::registerPayment(2,$user_id,null,56,$payment);
            $ub = BillingUserBalance::find()->andWhere(['user_vid' => $user_id])->one();
            $ub->balance -= $payment;
            $ub->save();
    }
}
