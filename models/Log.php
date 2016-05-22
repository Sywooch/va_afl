<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $author
 * @property string $subject
 * @property string $action
 * @property string $type
 * @property string $sub_type
 * @property string $old
 * @property string $new
 * @property string $datetime
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    public static function action($subject, $action, $type, $sub_type, $old = '', $new = '', $author = 1){
        $log = new Log();
        $log->subject = $subject;
        $log->action = $action;
        $log->type = $type;
        $log->sub_type = $sub_type;
        $log->old = $old;
        $log->new = $new;
        $log->author = $author == 1 ? Yii::$app->user->id : $author;
        $log->save();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['old', 'new'], 'string'],
            [['action', 'type', 'sub_type'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'action' => Yii::t('app', 'Action'),
            'type' => Yii::t('app', 'Type'),
            'sub_type' => Yii::t('app', 'Sub Type'),
            'old' => Yii::t('app', 'Old'),
            'new' => Yii::t('app', 'New'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'author']);
    }
}
