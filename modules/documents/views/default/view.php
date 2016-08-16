<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
/**
 * @var $model \app\models\Content
 */

/* @var $this yii\web\View */
/* @var $model app\models\Content */
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Content;
use app\models\ContentCategories;

$this->title = $model->name.' ('.$model->createdDT->format('d.m.Y').' )';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'documents'), 'url' => ['/documents']];
$this->params['breadcrumbs'][] = [
    'label' => $model->categoryInfo->name,
    'url' => ['/documents/' . $model->categoryInfo->link]
];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\ContentAsset::register($this);
?>
    <div class="col-md-9">
        <div class="panel panel-documents">
            <div class="panel-body">
                <h1><?= $model->name ?></h1>

                <ul class="list-inline">
                    <li><?= $model->createdDT->format('d F Y') ?></li>
                    <li><a href="/documents/list/<?= $model->categoryInfo->link ?>"><?= $model->categoryInfo->name ?></a></li>
                    <?php if (!empty($model->forum)) : ?>
                        <li><a target="_blank" href="<?= $model->forum ?>"><i class="fa fa-comments"></i> <?=
                                Yii::t(
                                    'app',
                                    'Discuss in forum'
                                ) ?></a></li>
                    <?php endif; ?>
                    <li>Views: <?= $model->views ?></li>
                </ul>
                <?= $model->text ?>
                <hr>
                <?php if (Yii::$app->user->can($model->categoryInfo->access_edit) || Yii::$app->user->can(
                        'content/edit'
                    )
                ): ?>
                    <?=
                    Html::a(
                        Yii::t('app', 'Go to Content'),
                        ['/content/view/' . $model->id],
                        ['class' => 'btn btn-primary', 'target' => '_blank']
                    ) ?>
                <?php endif; ?>
                <a href="javascript:content_like(<?= $model->id ?>);" id="btn_like_<?= $model->id ?>"
                   class="m-r-15 btn btn-default<?= $model->like ? ' disabled btn-success' : '' ?>"><i
                        class="fa fa-thumbs-up fa-fw"></i> Like</a>
                <button class="btn btn-default" id="btn_like_<?= $model->id ?>_num"
                        disabled><?= $model->likesCount ?></button>
                <hr>
                <legend>
                    <h3><?= Yii::t('app', 'Comments') ?></h3>
                </legend>
                <?php if (empty($model->forum)) : ?>
                    <div id="comments" style="min-height: 100px">

                    </div>
                    <div style="padding-top: 10px">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" name="message" id="message"
                                   placeholder="<?= Yii::t('app', 'Enter your message here') ?>.">
                    <span class="input-group-btn">
                        <button onclick="content_comment(<?= $model->id ?>)" class="btn btn-primary btn-sm"
                                type="button"><?= Yii::t('app', 'Send') ?></button>
                    </span>
                        </div>
                    </div>
                    <script>
                        setTimeout(function () {
                            $("#comments").load("/content/comments/<?= $model->id ?>");
                        }, 400);
                    </script>
                    <hr>
                    <?php else: ?>
                    <div class="note note-info">
                        <h4><a target="_blank" href="<?= $model->forum ?>"><i class="fa fa-comments"></i> <?=
                                Yii::t(
                                    'app',
                                    'Discuss in forum'
                                ) ?></a></h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?= $this->render('sidebar', ['categories' => ContentCategories::documents(), 'all' => Content::documents()]) ?>