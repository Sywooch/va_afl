<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fleet".
 *
 * @property string $regnum
 * @property string $type_code
 * @property string $full_type
 * @property integer $status
 * @property integer $user_id
 * @property string $home_airport
 * @property string $location
 * @property string $image_path
 * @property integer $squadron_id
 * @property integer $max_pax
 * @property integer $max_hrs
 */
class Fleet extends \yii\db\ActiveRecord
{
    public static function getForBooking(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $acftype = empty($ids[0]) ? null : $ids[0];
            if ($acftype != null) {
                foreach (Fleet::find()->andWhere(['type_code' => $acftype])->
                             andWhere(['location' => Users::getAuthUser()->pilot->location])->asArray()->all(
                             ) as $data) {
                    $out[] = ['id' => $data['id'], 'name' => $data['regnum']];
                }
                return Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fleet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['regnum'], 'required'],
            [['status', 'user_id', 'squadron_id', 'max_pax', 'max_hrs'], 'integer'],
            [['image_path'], 'string'],
            [['regnum', 'type_code'], 'string', 'max' => 10],
            [['full_type'], 'string', 'max' => 100],
            [['home_airport', 'location'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'regnum' => 'Regnum',
            'type_code' => 'Type Code',
            'full_type' => 'Full Type',
            'status' => 'Status',
            'user_id' => 'User ID',
            'home_airport' => 'Home Airport',
            'location' => 'Location',
            'image_path' => 'Image Path',
            'squadron_id' => 'Squadron ID',
            'max_pax' => 'Max Pax',
            'max_hrs' => 'Max Hrs',
        ];
    }
}
