<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Events\EventsCategories */

$this->title = Yii::t('app', 'Create Events Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
