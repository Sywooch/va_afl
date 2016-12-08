<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Events\EventsCategories */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Events Categories',
]) . $model->event_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->event_id, 'url' => ['view', 'event_id' => $model->event_id, 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="events-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
