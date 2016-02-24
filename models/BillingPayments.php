<?php

namespace app\models;

use Yii;

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
            [['id'], 'required'],
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
}
