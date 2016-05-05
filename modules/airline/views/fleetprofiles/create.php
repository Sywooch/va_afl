<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FleetProfiles */

$this->title = Yii::t('app', 'Create Fleet Profiles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleet Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-profiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
