<?php
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Top').' '.Yii::t('top', 'by mouth');
?>
<?= $this->render('grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>