<?php
use yii\bootstrap\Html;

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
];?>
<div class="edit-form">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= $this->title ?></h4>
        </div>
        <div class="panel-body panel-form" style="padding:10px !important;">
            <?= $this->render('settings_form', ['user' => $user]) ?>
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary pull-right', 'onClick' => 'submitform()']) ?>
            <script>
                function submitform(){ $('#profile_settings').submit(); }
            </script>
        </div>
    </div>
</div>