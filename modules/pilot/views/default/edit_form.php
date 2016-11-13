<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin(
    [
        'action' => '/pilot/edit/' . $pilot->user_id,
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered'],
        'id' => 'profile_edit',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]
); ?>

<?= $form->field($pilot, 'avatar')->fileInput() ?>
<?= $form->field($pilot, 'user_comments')->textArea(['rows' => '6']) ?>
<?php if (Yii::$app->user->can('supervisor')): ?>
    <?= $form->field($pilot, 'avail_booking')->dropDownList(['1' => 'On','0' => 'Off']) ?>
    <?= $form->field($pilot, 'staff_comments')->textArea(['rows' => '6']) ?>
    <?= $form->field($pilot, 'center_comments')->textArea(['rows' => '6']) ?>
<?php endif; ?>
<?= $form->field($pilot, 'stream_link')->textInput(['maxlength' => true]) ?>
<?php if(empty($pilot->vk_id)): ?>
<div class="form-group field-userpilot-vk_id">
    <label class="control-label col-sm-4" for="userpilot-vk_id">VK</label>

    <div class="col-sm-8">
        <?php /*?>
        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

        <script type="text/javascript">
            VK.init({apiId: 5497954});
        </script>

        <!-- Put this div tag to the place, where Auth block will be -->
        <div id="vk_auth"></div>
        <div id="vk_success" style="display: none"><button class="btn btn-success btn-disabled">You are successful auth in VK</button><div>
        <script type="text/javascript">
            VK.Widgets.Auth("vk_auth", {width: "200px", onAuth: function (data) {
                $(document).ready(function () {
                    $('input[name="UserPilot[vk_id]"]').val(data['uid']);
                    $("#vk_auth").hide();
                    $("#vk_success").show();
                });
            } });
        </script>
        <input type="hidden" id="userpilot-vk_id" name="UserPilot[vk_id]" value="<?= $pilot->vk_id ?>">
        <?php */ ?>

        <div class="help-block help-block-error "></div>
    </div>
</div>
<?php endif; ?>
<?php ActiveForm::end(); ?>


