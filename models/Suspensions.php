<?php

namespace app\models;

use app\components\Slack;
use app\models\Content;
use app\models\Services\notifications\Notification;
use Yii;

/**
 * This is the model class for table "{{%suspensions}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $issue_user
 * @property string $issue_datetime
 * @property integer $flight_id
 * @property integer $content_id
 *
 * @property Booking $flight
 * @property Content $content
 */
class Suspensions extends \yii\db\ActiveRecord
{
    const TEMPLATE = 724;
    public static $types = [
        'mvzType',
        'oprType',
        'eetType',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suspensions}}';
    }

    public static function check($flight)
    {
        $suspensions = [];
        $errors_en = '';
        $errors_ru = '';
        foreach (self::$types as $type) {
                $class_name = "app\\models\\Flights\\Suspensions\\" . str_replace('.php', '', $type);
                $class = new $class_name;
                if (!empty($_susp = call_user_func_array([$class, "startCheck"], ['flight' => $flight]))) {
                    Yii::trace($_susp);
                    $suspensions = array_merge($suspensions, $_susp);
                }
        }

        foreach ($suspensions as $suspension) {
            $errors_ru .= '<li><b>' . $suspension[0] . '</b> - ' . $suspension[2] . '</li>';
            $errors_en .= '<li><b>' . $suspension[1] . '</b> - ' . $suspension[2] . '</li>';

            $_suspension = new Suspensions();
            $_suspension->user_id = $flight->user_id;
            $_suspension->issue_user = 0;
            $_suspension->issue_datetime = gmdate('Y-m-d H:i:s');
            $_suspension->flight_id = $flight->id;
            $_suspension->content_id = $suspension[3];
            $_suspension->description = $suspension[2];
            $_suspension->save();
            Yii::trace($_suspension->errors);
        }

        if (!empty($suspensions)) {
            $array = [
                '[flight_name]' => $flight->flightName,
                '[flight_id]' => $flight->id,
                '[errors_en]' => $errors_en,
                '[errors_ru]' => $errors_ru,
            ];

            $slack = new Slack('#flights', $array['[flight_name]'].' - '.$array['[errors_ru]']);
            $slack->addLink('http://va-afl.su/airline/flights/view/'.$array['[flight_id]']);
            $slack->sent();

            Notification::add($flight->user_id, 0, Content::template(self::TEMPLATE, $array), 'fa-times-circle-o', 'red');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'issue_datetime', 'content_id'], 'required'],
            [['description'], 'string'],
            [['user_id', 'issue_user', 'flight_id', 'content_id', 'subject'], 'integer'],
            [['issue_datetime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'issue_user' => Yii::t('app', 'Issue User'),
            'issue_datetime' => Yii::t('app', 'Issue Datetime'),
            'flight_id' => Yii::t('app', 'Flight ID'),
            'content_id' => Yii::t('app', 'Content ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Booking::className(), ['id' => 'flight_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
