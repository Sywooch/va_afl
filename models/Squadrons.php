<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "squads".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $abbr
 */
class Squadrons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'squadrons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en', 'abbr'], 'string', 'max' => 100],
            [['leader'], 'integer'],
            [['abbr'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'abbr' => 'Abbr',
            'leader' => 'Leader',
        ];
    }

    public function getSquadronMembers()
    {
        return $this->hasMany(SquadronUsers::className(), ['squadron_id' => 'id']);
    }

    public function getUserStatus()
    {
        $data = $this->getSquadronMembers()->andWhere(['user_id' => Yii::$app->user->id])->one();
        return $data ? $data->status : false;
    }

    public function getSquadronInfo()
    {
        return Content::find()->where(['machine_name' => $this->abbr . '_info'])->one();
    }

    public function getSquadronRules()
    {
        return Content::find()->where(['machine_name' => $this->abbr . '_rules'])->one();
    }

    public function getTotalPax()
    {
        return Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $this->id)->sum('pob');
    }

    public function getTotalVUC()
    {
        return Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $this->id)->sum('vucs');
    }

    public function getTotalMiles()
    {
        return Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $this->id)->sum('nm');
    }

    public function getFleet()
    {
        return $this->hasMany(Fleet::className(), ['squadron_id' => 'id']);
    }

    public function getFlights()
    {
        return Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $this->id)->all();
    }
}
