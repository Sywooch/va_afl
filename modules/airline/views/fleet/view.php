<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fleet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('fleet/edit')): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"></h4>
        </div>

        <?php if ($model->image_path) : ?>
            <img class="img-responsive center-block" height="350px" src="<?= $model->image_path ?>">
            <div class="col-md-12">
                <hr>
            </div>
        <?php endif; ?>

        <div class="panel-body">
            <?=
            DetailView::widget(
                [
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'regnum',
                        'type_code',
                        'full_type',
                        'status',
                        'user_id',
                        'home_airport',
                        'location',
                        'squadron_id',
                        'max_pax',
                        'max_hrs',
                        'selcal',
                    ],
                ]
            ) ?>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
