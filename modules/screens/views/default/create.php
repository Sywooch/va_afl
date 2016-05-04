<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = Yii::t('screens', 'Upload Screen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screens'), 'url' => ['/screens']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body panel-form" style="padding:10px !important;">
            <?=
            $this->render(
                '_form',
                [
                    'model' => $model,
                ]
            ) ?>
        </div>
    </div>
</div>