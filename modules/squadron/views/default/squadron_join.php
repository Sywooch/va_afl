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
                        <h4 class="panel-title"><?= Yii::t('app', 'Join squadron') ?></h4>
                    </div>
                    <div class="panel-body panel-form" style="color: #707478 !important; padding:10px !important;">
                        <?= $squadron->squadronRules->text ?>
                    </div>
                    <div class="panel-footer">
                        <?= Html::checkbox('rules_agree', false,
                            ['label' => Yii::t('squadron', 'I understand everything, ready to fly!'), 'id' => 'rules_agree', 'onChange' => 'submitform()']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <?= Html::a(Yii::t('app', 'Join'), Url::to(['join']),
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