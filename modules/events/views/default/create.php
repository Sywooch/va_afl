<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = Yii::t('app', 'Create Events');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <a class="btn btn-danger btn-xs pull-right" href="/content/create" target="_blank" data-method="post"
       data-params="{&quot;category_id&quot;:7}">Add Content</a>
    <?=
    $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>
</div>
