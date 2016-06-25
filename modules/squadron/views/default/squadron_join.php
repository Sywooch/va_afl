<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= Yii::t('app', 'Join sqaudron') ?></h4>
                    </div>
                    <div class="panel-body panel-form" style="color: #707478 !important; padding:10px !important;">
                        <?= $squadron->squadronRules->text ?>
                    </div>
                    <div class="panel-footer">
                        <?= Html::checkbox('rules_agree', false,
                            ['label' => 'I understand and agree with the rules', 'id' => 'rules_agree', 'onChange' => 'submitform()']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <?= Html::a('Подать заявку', Url::to(['join']),
                    [
                        'class' => 'btn btn-primary disabled',
                        'id' => 'join_button',
                        'data' => [
                            'method' => 'post',
                            'params' => ['squadron' => $squadron->id]
                        ]
                    ]); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function submitform() {

    }

</script>