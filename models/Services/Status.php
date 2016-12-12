<?php

namespace app\models\Services;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id
 * @property integer $status
 * @property string $last_change
 */
class Status extends \yii\db\ActiveRecord
{
    const TRACKER = 1;
    const TRACKER_ON = 1;
    const TRACKER_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['last_change'], 'required'],
            [['last_change'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'last_change' => Yii::t('app', 'Last Change'),
        ];
    }
}
