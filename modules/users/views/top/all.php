<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Top');
?>
<?= $this->render('grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>