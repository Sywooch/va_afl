<?php
use yii\helpers\Html;
?>
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= Yii::t('app', 'Profile editor') ?></h4>
                    </div>
                    <div class="panel-body panel-form" style="padding:10px !important;">
                        <?= $this->render('edit_form', ['user' => $user]) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <?=
                Html::submitButton(
                    Yii::t('app', 'Update'),
                    ['class' => 'btn btn-primary pull-right', 'onClick' => 'submitform()']
                ) ?>
            </div>
        </div>
    </div>
</div>