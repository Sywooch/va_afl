<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\events\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= Html::encode($this->title) ?>
                <?php if (Yii::$app->user->can('events/edit')): ?>
                    <a class="btn btn-success btn-xs pull-right" href="/events/create"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </h4>
        </div>

        <div class="panel-body">
            <div class="container">
                <?=
                \talma\widgets\FullCalendar::widget(
                    [
                        'googleCalendar' => false,
                        'config' => [
                            'firstDay' => 1,
                            'lang' => Yii::$app->language == 'RU' ? 'ru' : 'en',
                            'events' => $events
                        ],
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>
