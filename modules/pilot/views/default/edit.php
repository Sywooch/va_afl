<?php
use yii\bootstrap\Html;

$this->title = Yii::t('app', 'Profile editor');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
]; ?>
<div class="edit-form">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= $this->title ?></h4>
        </div>
        <div class="panel-body panel-form" style="padding:10px !important;">
            <?= $this->render('edit_form', ['user' => $user]) ?>
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary pull-right', 'onClick' => 'submitform()']) ?>
            <script>
                function submitform(){ $('#profile_edit').submit(); }
            </script>
        </div>
    </div>
</div>