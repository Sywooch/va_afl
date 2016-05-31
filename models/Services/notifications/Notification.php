<?php

namespace app\models\Services\notifications;

use Yii;

use app\models\Users;
use app\models\Content;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property integer $to
 * @property integer $from
 * @property integer $content_id
 * @property integer $read
 * @property string $created
 * @property string $icon
 * @property string $color
 * @property string $link
 *
 * @property Users $toUser
 * @property Users $fromUser
 * @property Content $content
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    public static function add($vid, $author, $id)
    {
        $notification = new Notification;
        $notification->to = $vid;
        $notification->from = $author;
        $notification->content_id = $id;
        $notification->save();
    }

    public static function read($limit = 5)
    {
        foreach (self::last($limit) as $notification) {
            $notification->read = 1;
            $notification->save();
        }
    }

    public static function user()
    {
        return self::find()->where(['to' => Yii::$app->user->identity->vid])->andWhere(['read' => 0]);
    }

    public static function last($limit = 5)
    {
        return self::user()->orderBy('created desc')->limit($limit)->all();
    }

    public static function all()
    {
        return self::user()->orderBy('created desc')->all();
    }


    public static function count()
    {
        return self::user()->count();
    }

    public static function userList($limit = 50)
    {
        return self::find()->where(['to' => Yii::$app->user->identity->vid])->orderBy('id desc')->limit($limit)->all();
    }

    public function getIconHTML()
    {
        return $this->icon ? '<i class="fa ' . $this->icon . ' media-object notification-object bg-' . $this->color . '"></i>' : '<img src="' . $this->fromUser->avatarLink . '" class="media-object img-circle" alt=""/>';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'content_id'], 'required'],
            [['to', 'from', 'content_id', 'read'], 'integer'],
            [['created'], 'safe'],
            [['icon', 'color', 'link'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'to' => Yii::t('app', 'To'),
            'from' => Yii::t('app', 'From'),
            'content_id' => Yii::t('app', 'Content ID'),
            'read' => Yii::t('app', 'Read'),
            'created' => Yii::t('app', 'Created'),
            'tag' => Yii::t('app', 'Tag'),
            'tag_color' => Yii::t('app', 'Tag Color'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(Users::className(), ['vid' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
