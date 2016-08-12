<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "billing_user_balance".
 *
 * @property integer $id
 * @property integer $user_vid
 * @property double $balance
 * @property string $lastupdate
 */
class BillingUserBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing_user_balance';
    }

    public static function addMoney($user_id, $flight_id, $payment, $type)
    {
        if (!$ub = self::find()->andWhere(['user_vid' => $user_id])->one()) {
            $ub = new BillingUserBalance();
        }

        $ub->balance += $payment;
        $ub->lastupdate = date('Y-m-d H:i:s');
        $ub->save();

        BillingPayments::registerPayment(1,$user_id, $flight_id, $type, $payment);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_vid'], 'required'],
            [['user_vid'], 'integer'],
            [['balance', 'to', 'out'], 'number'],
            [['lastupdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_vid' => 'User Vid',
            'balance' => 'Balance',
            'lastupdate' => 'Lastupdate',
        ];
    }
    public static function checkHavingMoney($vid,$money)
    {
        $balance = self::find()->andWhere(['user_vid'=>$vid])->one();
        if(!$balance) return false;
        return $balance->balance >= $money;
    }
}
