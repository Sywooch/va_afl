<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.01.16
 * Time: 21:28
 */

use app\assets\MapAsset;
use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

MapAsset::register($this);

/* @var $this yii\web\View */
/* @var $user app\models\Airports */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Pilot Center');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
];

?>
<div id="map" style="width: 500px; height: 400px;"></div>
<script>
    setTimeout(function () {
        initialize(464736);
    },500);
</script>