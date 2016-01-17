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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_vid'], 'required'],
            [['id', 'user_vid'], 'integer'],
            [['balance'], 'number'],
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
}
