<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Items\ItemsTypes */

$this->title = Yii::t('app', 'Create Items Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
