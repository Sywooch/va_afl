<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fleet_profiles".
 *
 * @property integer $id
 * @property string $name
 * @property string $pbn
 * @property string $nav
 * @property string $sel
 * @property string $rvr
 * @property string $equipment
 * @property string $transponder
 *
 * @property Fleet[] $fleets
 */
class FleetProfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fleet_profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pbn', 'nav', 'rvr', 'equipment', 'transponder'], 'string', 'max' => 50],
            [['rmk'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'pbn' => Yii::t('app', 'Pbn'),
            'nav' => Yii::t('app', 'Nav'),
            'rvr' => Yii::t('app', 'Rvr'),
            'equipment' => Yii::t('app', 'Equipment'),
            'transponder' => Yii::t('app', 'Transponder'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFleets()
    {
        return $this->hasMany(Fleet::className(), ['profile' => 'id']);
    }
}
