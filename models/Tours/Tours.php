<?php

namespace app\models\Tours;

use Yii;

use app\models\Content;

/**
 * This is the model class for table "{{%tours}}".
 *
 * @property integer $id
 * @property integer $content_id
 * @property integer $users
 * @property integer $status
 * @property string $access
 *
 * @property Content $content
 * @property ToursLegs[] $toursLegs
 * @property ToursUsers[] $toursUsers
 */
class Tours extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tours}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id'], 'required'],
            [['content_id', 'users', 'status'], 'integer'],
            [['access'], 'string', 'max' => 100],
            [['start', 'stop'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'users' => Yii::t('app', 'Users'),
            'status' => Yii::t('app', 'Status'),
            'access' => Yii::t('app', 'Access'),
        ];
    }

    public function getUserNo()
    {
        $user = ToursUsers::findOne(['user_id' => Yii::$app->user->id, 'tour_id' => $this->id]);
        return !$user || $user->status == ToursUsers::STATUS_UNASSIGNED ? false : true;
    }

    public function getUserAssign()
    {
        return ToursUsers::findOne(['user_id' => Yii::$app->user->id, 'tour_id' => $this->id])->status
        == ToursUsers::STATUS_ASSIGNED ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToursLegs()
    {
        return $this->hasMany(ToursLegs::className(), ['tour_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToursUsersLegs()
    {
        return $this->hasMany(ToursUsersLegs::className(), ['tour_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToursUsers()
    {
        return $this->hasMany(ToursUsers::className(), ['tour_id' => 'id']);
    }
}
