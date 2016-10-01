<?php
/* @var $this yii\web\View */
?>
<h1>top/all</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<?= $this->render('grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>