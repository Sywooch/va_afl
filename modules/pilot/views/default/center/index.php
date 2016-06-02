<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Pilot Center');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

?>
<div class="row">
    <div class="col-md-12">
    <?= $this->render('header', ['user' => $user, 'flight' => $flight]) ?>
    </div>
    <div class="col-md-8">
        <?= $this->render('onlinetable', ['onlineProvider' => $onlineProvider]) ?>
        <?= $this->render('top', ['top' => $topProvider]) ?>
    </div>
    <div class="col-md-4">
        <!-- begin panel -->
        <?= $this->render('news', ['news' => $news]) ?>
        <?= $this->render('events', ['events' => $events]) ?>
        <?= $this->render('events_calendar', ['eventsCalendar' => $eventsCalendar]) ?>
    </div>
</div>