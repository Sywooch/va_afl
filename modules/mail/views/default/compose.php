<?php
use \yii\web\JsExpression;

use kartik\select2\Select2;

$this->registerCssFile('/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css');
$this->registerCssFile('/plugins/jquery-tag-it/css/jquery.tagit.css');
?>
<div class="vertical-box">
    <?= $this->render('_sidebar', ['type' => $type]) ?>
    <div class="vertical-box-column">
        <?= $this->render('_top') ?>
        <div class="wrapper">
            <div class="p-30 bg-white">
                <?php switch ($status): ?><?php case 0: ?>
                    <form action="" method="POST" name="email_to_form">
                        <label class="control-label">To:</label>

                        <div class="m-b-15">
                            <?=
                            Select2::widget(
                                [
                                    'name' => 'to',
                                    'value' => '',
                                    'options' => ['placeholder' => 'Users...', 'multiple' => true],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'ajax' => [
                                            'url' => \yii\helpers\Url::to('/site/getusers'),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                    ]
                                ]
                            );
                            ?>
                        </div>
                        <label class="control-label">Subject:</label>

                        <div class="m-b-15">
                            <input type="text" name="topic" id="topic" class="form-control">
                        </div>
                        <label class="control-label">Content:</label>

                        <div class="m-b-15">
                            <textarea class="textarea form-control" name="text" id="text" rows="12"
                                      placeholder="Enter text ..."></textarea>
                        </div>
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                        <button type="submit" class="btn btn-primary p-l-40 p-r-40">Send</button>
                    </form>
                    <?php break; ?>
                <?php
                    case 1: ?>
                        <div class="note note-danger">
                            <h4>Error</h4>
                        </div>
                        <?php break; ?>
                    <?php
                    case 2: ?>
                        <div class="note note-success">
                            <h4>Success</h4>
                        </div>
                        <?php break; ?>
                    <?php endswitch; ?>
            </div>
        </div>
    </div>
</div>