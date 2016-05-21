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
    <?= $this->render('header', ['user' => $user]) ?>
    </div>
    <div class="col-md-12">
        <div class="progress progress-striped active" style="height: 30px">
            <div class="progress-bar progress-bar-inverse" style="font-weight: lighter; width: 80%"><?=  Html::tag(
                    'span',
                    '600000 / 750000',
                    [
                        'title' => Yii::t('app', 'Experience'),
                        'data-toggle' => 'tooltip',
                        'data-placement' => "top"
                    ]
                )?></div>
        </div>
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
        <?= Html::button(
            'Edit profile',
            ['class' => 'btn btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#modal-dialog']
        ) ?>
    </div>
</div>


<?= $this->render('../edit_modal', ['user' => $user]) ?>