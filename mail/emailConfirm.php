<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['pilot/default/confirmtoken', 'id' => $token]);
?>

Hello, <?= Html::encode($user->full_name) ?>!

To confirm your email on VAG AFL, please use this link

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>
