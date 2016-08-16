<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\components\Helper;

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

    public static function icao($icao)
    {
        return self::find()->where(['icao' => $icao])->one();
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
            'icao' => Yii::t('app', 'ICAO'),
            'name' => Yii::t('app', 'Name'),
            'lat' => Yii::t('app', 'Latitude'),
            'lon' => Yii::t('app', 'Longitude'),
            'alt' => Yii::t('app', 'Altitude'),
            'iata' => Yii::t('app', 'IATA'),
            'city' => Yii::t('app', 'City'),
            'iso' => Yii::t('app', 'ISO'),
            'FIR' => Yii::t('app', 'FIR'),
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

    /**
     * Поиск аэропортов по ICAO коду
     * @param $q string Search id from default answer
     * @param $id string Search id from default answer
     */
    public static function searchByICAO($q = null, $id = null)
    {
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $query = new Query();
            $query->select("icao as id, concat_ws(' - ', `icao`, `name`) AS text")
                ->from('airports')
                ->where('icao LIKE "%' . $q . '%"')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }

        return $out;
    }

    public function getCountry()
    {
        return $this->hasOne(Isocodes::className(), ['code' => 'iso']);
    }

    public function getFlaglink()
    {
        return Helper::getFlagLink($this->iso);
    }

    public function getCoord(){
        return Helper::dec2deg($this->lat,'lat').' '.Helper::dec2deg($this->lon,'lon');
    }

    public function getFullname(){
        return !empty($this->iata) ? $this->name.' ('.$this->iata.' / '.$this->icao.')' : $this->name . ' ('. $this->icao . ')';
    }
}
