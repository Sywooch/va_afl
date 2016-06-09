<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tours');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="panel-body">
        <?php foreach ($tours as $tour): ?>
            <div class="container well" style="background-color: transparent">
                <h2><a href='/tours/<?= $tour->id ?>'><?= $tour->content->name ?></a></h2>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <img style="width: 170px;"
                             src="<?= $tour->content->imgLink ?>">
                    </div>
                    <div class="col-md-9">
                        <?= $tour->content->description ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success">
                                <span class="badge"><?= $tour->getToursUsers()->andWhere(['status' => \app\models\Tours\ToursUsers::STATUS_COMPLETED])->count() ?></span>
                                <?= Yii::t('app', 'Completed') ?>
                            </li>
                            <li class="list-group-item list-group-item-warning">
                                <span class="badge"><?= $tour->getToursUsers()->andWhere(['status' => \app\models\Tours\ToursUsers::STATUS_ACTIVE])->count() ?></span>
                                <?= Yii::t('app', 'In progress') ?>
                            </li>
                            <li class="list-group-item">
                                <span class="badge"><?= $tour->getToursLegs()->count() ?></span>
                                <?= Yii::t('app', 'Total Legs') ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>