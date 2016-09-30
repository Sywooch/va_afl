<?php

namespace app\models\Top;

use app\components\Stats;
use app\models\Users;
use Yii;

/**
 * This is the model class for table "{{%top}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $mouth
 * @property integer $year
 * @property integer $exp_count
 * @property integer $exp_pos
 * @property integer $flights_count
 * @property integer $flights_pos
 * @property integer $hours_count
 * @property integer $hours_pos
 * @property integer $pax_count
 * @property integer $pax_pos
 *
 * @property Users $user
 */
class Top extends \yii\db\ActiveRecord
{
    public static $count_fields = [
        'exp_count',
        'flights_count',
        'hours_count',
        'pax_count',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%top}}';
    }

    public static function user($user, $mouth = 0, $year = 0)
    {
        if (!$record = self::findOne(['user_id' => $user, 'mouth' => $mouth, 'year' => $year])) {
            $record = new self;
            $record->user_id = $user;
            $record->mouth = $mouth;
            $record->year = $year;
        }

        $record->collector();
        if ($record->flights_count > 0) {
            $record->save();
        }
    }

    public function collector()
    {
        $collector = new StatsCollector($this);
        foreach (Top::$count_fields as $field) {
            $this->$field = $collector->$field;
        }
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'mouth',
                    'year',
                    /*'exp_count',
                    'exp_pos',
                    'flights_count',
                    'flights_pos',
                    'hours_count',
                    'hours_pos',
                    'pax_count',
                    'pax_pos'*/
                ],
                'required'
            ],
            [
                [
                    'user_id',
                    'mouth',
                    'year',
                    'exp_count',
                    'exp_pos',
                    'flights_count',
                    'flights_pos',
                    'hours_count',
                    'hours_pos',
                    'pax_count',
                    'pax_pos'
                ],
                'integer'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mouth' => 'Mouth',
            'year' => 'Year',
            'exp_count' => 'Exp Count',
            'exp_pos' => 'Exp Num',
            'flights_count' => 'Flights Count',
            'flights_pos' => 'Flight Pos',
            'hours_count' => 'Hours Count',
            'hours_pos' => 'Hours Pos',
            'pax_count' => 'Pax Count',
            'pax_pos' => 'Pax Pos',
        ];
    }
}
