<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "actypes".
 *
 * @property string $code
 * @property string $manufacturer
 * @property string $name
 * @property string $turbulence
 * @property string $type
 * @property string $eng_type
 * @property integer $eng_qty
 */
class Actypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actypes';
    }

    /**
     * Поиск самолётов по ICAO коду
     * @param $q string Search id from default answer
     * @param $id string Search id from default answer
     */
    public static function searchByICAO($q = null, $id = null)
    {
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $query = new Query();
            $query->select(["code AS id", "CONCAT(code, ' - ', manufacturer, ' ', name) AS text"])
                ->from('actypes')
                ->where("code LIKE '%" . $q . "%'")
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }

        return $out;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['eng_qty'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['manufacturer', 'name'], 'string', 'max' => 150],
            [['turbulence'], 'string', 'max' => 1],
            [['type', 'eng_type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'manufacturer' => 'Manufacturer',
            'name' => 'Name',
            'turbulence' => 'Turbulence',
            'type' => 'Type',
            'eng_type' => 'Eng Type',
            'eng_qty' => 'Eng Qty',
        ];
    }
}
