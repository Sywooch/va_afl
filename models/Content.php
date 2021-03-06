<?php

namespace app\models;

use app\models\Events\Events;
use Yii;
use yii\web\NotFoundHttpException;

use app\components\Levels;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $text_ru
 * @property string $text_en
 * @property string $img
 * @property string $preview
 * @property int $author
 * @property string $created
 */
class Content extends \yii\db\ActiveRecord
{
    public static $fields = [
        'name_en',
        'name_ru',
        'text_ru',
        'text_en',
        'description_ru',
        'description_en',
        'site',
        'icon'
    ];
    /**
     * @inheritdoc
     */

    public $img_file;
    public $preview_file;

    public static function tableName()
    {
        return 'content';
    }

    public static function news($limit = 50)
    {
        return self::prepare(
            self::find()->joinWith('categoryInfo')->where(['content_categories.news' => 1])->orderBy(
                'created desc'
            )->limit($limit)->all()
        );
    }

    public static function prepare($mNews)
    {
        $news = [];
        foreach ($mNews as $new) {
            if (empty($new->categoryInfo->access_read) || Yii::$app->user->can($new->categoryInfo->access_read)) {
                $news[] = $new;
            }
        }
        return $news;
    }

    public static function feed()
    {
        return self::prepare(
            self::find()->joinWith('categoryInfo')->where(['content_categories.feed' => 1])->all()
        );
    }

    public static function documents($limit = 50)
    {
        return self::prepare(
            self::find()->joinWith('categoryInfo')->where(['content_categories.documents' => 1])->orderBy(
                'created desc'
            )->limit($limit)->all()
        );
    }

    public static function newsCategory($link)
    {
        return self::prepare(
            self::find()->joinWith('categoryInfo')->where(
                ['content_categories.news' => 1, 'content_categories.link' => $link]
            )->orderBy('created desc')->all()
        );
    }

    public static function documentsCategory($link)
    {
        return self::prepare(
            self::find()->joinWith('categoryInfo')->where(
                ['content_categories.documents' => 1, 'content_categories.link' => $link]
            )->orderBy('created desc')->all()
        );
    }

    public static function view($id)
    {
        $key = preg_match('/^\d+$/', $id) ? 'id' : 'machine_name';

        $model = self::findModel([$key => $id]);
        $model->views++;
        $model->save();

        if (!Yii::$app->user->can('content/edit') && (!Yii::$app->user->can(
                    $model->categoryInfo->access_read
                ) && !empty($model->categoryInfo->access_read))
        ) {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        return $model;
    }

    protected static function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function template($template, $array, $category = 22, $author = 0)
    {
        $temp = self::findOne($template);

        $content = new Content();
        $content->category = $category;
        Yii::trace($array);
        foreach (self::$fields as $field) {
            $tempField = $temp->$field;
            foreach ($array as $from => $to) {
                Yii::trace($field . ' - ' . $from . '/' . $to);
                $content->$field = str_replace($from, $to, $tempField);
                $tempField = $content->$field;
            }
        }

        $content->author = $author;
        $content->save();

        return $content->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'name_ru', 'name_en'], 'required'],
            [['category', 'author', 'views'], 'integer'],
            [['text_ru', 'text_en'], 'string'],
            [['created'], 'safe'],
            [['name_ru', 'name_en'], 'string', 'max' => 150],
            [['icon', 'color'], 'string', 'max' => 50],
            [['description_ru', 'description_en', 'forum', 'site'], 'string', 'max' => 255],
            [['img', 'preview'], 'string', 'skipOnEmpty' => true, 'max' => 255],
            [['machine_name'], 'string', 'max' => 100],
            [['machine_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_ru' => Yii::t('app', 'Name') . ' ' . Yii::t('app', '(Ru.)'),
            'name_en' => Yii::t('app', 'Name') . ' ' . Yii::t('app', '(En.)'),
            'text_ru' => Yii::t('app', 'Text') . ' ' . Yii::t('app', '(Ru.)'),
            'text_en' => Yii::t('app', 'Text') . ' ' . Yii::t('app', '(En.)'),
            'description_ru' => Yii::t('app', 'Description') . ' ' . Yii::t('app', '(Ru.)'),
            'description_en' => Yii::t('app', 'Description') . ' ' . Yii::t('app', '(En.)'),
            'img_file' => Yii::t('app', 'Image'),
            'icon' => Yii::t('app', 'Icon'),
            'color' => Yii::t('app', 'Color'),
        ];
    }

    /**
     * Вернёт имя
     * @return string
     */
    public function getName()
    {
        return $this->getLocale('name_ru', 'name_en');
    }

    /**
     * Возвращает переменную взависимости от языка
     * @param $ru string
     * @param $en string
     * @return string
     */
    private function getLocale($ru, $en)
    {
        return Yii::$app->language == 'RU' ? $this->$ru : $this->$en;
    }

    /**
     * Вернёт текст
     * @return string
     */
    public function getText()
    {
        return $this->getLocale('text_ru', 'text_en');
    }

    public function getDescription()
    {
        return $this->getLocale('description_ru', 'description_en');
    }

    public function getAuthorUser()
    {
        return $this->hasOne('app\models\Users', ['vid' => 'author']);
    }

    public function getCategoryInfo()
    {
        return $this->hasOne(ContentCategories::className(), ['id' => 'category']);
    }

    public function getLikes()
    {
        return $this->hasMany('app\models\ContentLikes', ['content_id' => 'id']);
    }

    public function getLikesCount()
    {
        return ContentLikes::find()->where(['content_id' => $this->id])->count();
    }

    public function getComments()
    {
        return $this->hasMany('app\models\ContentComments', ['content_id' => 'id']);
    }

    public function getCommentsCount()
    {
        return ContentComments::find()->where(['content_id' => $this->id])->count();
    }

    public function getImgLink()
    {
        if (empty($this->img)) {
            return "https://placeholdit.imgix.net/~text?txtsize=33&txt=no%20image&w=350&h=150";
        }

        if (strpos($this->img, 'http://') !== false || strpos($this->img, 'https://') !== false) {
            return $this->img;
        } else {
            return "https://va-afl.su/img/content/{$this->img}";
        }
    }

    public function viewsPlus()
    {
        $this->views++;
        $this->save();
    }

    public function getContentLink()
    {
        if (!empty($this->site)) {
            return $this->site;
        }

        if($this->category == 7) {
            if($event = Events::find()->where(['id' => $this->id])->orderBy('created desc')->one()){
                return '/events/'.$event->id;
            }
        }

        if ($this->categoryInfo->news == 1) {
            return '/news/' . $this->categoryInfo->link . '/' . ($this->machine_name ? $this->machine_name : $this->id);
        }

        if ($this->categoryInfo->documents == 1) {
            return '/documents/' . $this->categoryInfo->link . '/' . ($this->machine_name ? $this->machine_name : $this->id);
        }

        if ($this->category == 16) {
            return '/screens/view/' . $this->id;
        }
    }

    public function getCreatedDT()
    {
        return new \DateTime($this->created);
    }

    public function getLike()
    {
        return ContentLikes::check($this->id, Yii::$app->user->identity->vid);
    }

    public function getLink()
    {
        return empty($this->machine_name) ? $this->id : $this->machine_name;
    }

    public function like($user)
    {
        $like = new ContentLikes();
        $like->content_id = $this->id;
        $like->user_id = $user;
        $like->submit = gmdate("Y-m-d H:i:s");
        $like->save();

        Levels::addExp(1, $user);
        \app\models\Services\notifications\Content::like($user, Content::findOne($this->id));
    }

    public function comment($user, $text)
    {
        $comment = new ContentComments();
        $comment->content_id = $this->id;
        $comment->user_id = $user;
        $comment->write = gmdate("Y-m-d H:i:s");
        $comment->text = $text;
        $comment->save();

        Levels::addExp(2, $user);
        foreach (ContentComments::find()->where(['content_id' => $this->id])->groupBy('user_id')->all() as $record) {
            if ($user != $record->user_id) {
                \app\models\Services\notifications\Content::comment($user, $this, $text,
                    $record->user_id);
            }
        }
        \app\models\Services\notifications\Content::commentPublic($user, $this, $text);
    }
}
