<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 23.09.15
 * Time: 20:32
 */

$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
]; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <div class="raw">
            <div class="col md-6">
                
            </div>
        </div>
    </div>
</div>