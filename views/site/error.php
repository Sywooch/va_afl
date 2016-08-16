<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $exception->statusCode . ' - ' . $message . ' :-(';
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>
    <img src="http://akphoto1.ask.fm/334/116/375/-59996989-1tk77oq-ip6pp96m4iqskcf/original/avatar.jpg">
</div>
