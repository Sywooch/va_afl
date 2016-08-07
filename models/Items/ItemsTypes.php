<?php

namespace app\models\Items;

use Yii;

use app\models\Content;

/**
 * This is the model class for table "items_types".
 *
 * @property integer $type_id
 * @property integer $type
 * @property integer $content_id
 * @property string $created
 *
 * @property Items[] $items
 * @property Content $content
 */
class ItemsTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'content_id'], 'integer'],
            [['content_id'], 'required'],
            [['created'], 'safe'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => Yii::t('app', 'Type ID'),
            'type' => Yii::t('app', 'Type'),
            'content_id' => Yii::t('app', 'Content ID'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::className(), ['type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
