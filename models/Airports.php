<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "airports".
 *
 * @property integer $id
 * @property string $icao
 * @property string $name
 * @property double $lat
 * @property double $lon
 * @property integer $alt
 * @property string $iata
 * @property string $city
 * @property string $iso
 * @property string $FIR
 */
class Airports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'airports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lon', 'icao', 'name'], 'required'],
            [['lat', 'lon'], 'number'],
            [['alt'], 'integer'],
            [['icao'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 255],
            [['iata', 'FIR'], 'string', 'max' => 4],
            [['city'], 'string', 'max' => 50],
            [['iso'], 'string', 'max' => 2],
            [['icao'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icao' => Yii::t('app', 'Icao'),
            'name' => Yii::t('app', 'name'),
            'lat' => Yii::t('app', 'Latitude'),
            'lon' => Yii::t('app', 'Longitude'),
            'alt' => Yii::t('app', 'Altitude'),
            'iata' => Yii::t('app', 'IATA'),
            'city' => Yii::t('app', 'City'),
            'iso' => Yii::t('app', 'Iso'),
            'FIR' => Yii::t('app', 'Fir'),
        ];
    }

    public function search($params)
    {
        $query = self::find()->joinWith('country');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->session->get(get_parent_class($this) . 'Pagination'),
            ],
        ]);
        if (!($this->load($params))) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'icao', $this->icao])->
            andFilterWhere(['like', 'name', $this->name])->
            andFilterWhere(['like', 'city', $this->city]);
        return $dataProvider;
    }

    public function getCountry()
    {
        return $this->hasOne(Isocodes::className(), ['code' => 'iso']);
    }
}
