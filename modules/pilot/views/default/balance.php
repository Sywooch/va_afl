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

$this->title = Yii::t('app', 'Balance');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
]; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <?php echo \yii\grid\GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-bordered table-striped table-condensed'
                ],
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'direction',
                        'label' => Yii::t('flights', 'Type'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                switch($data->direction){
                                    case 2:
                                        return '<i class="fa fa-4 fa-arrow-circle-right" style="color:#8b0000;">' . $data->billing->priceType.'</i>';
                                        break;
                                    case 1:
                                        return '<i class="fa fa-4 fa-arrow-circle-left" style="color:darkgreen;">' . $data->billing->priceType.'</i>';
                                        break;
                                    default:
                                        return '';
                                }
                            }
                    ],
                    'payment',
                    [
                        'attribute' => 'dtime',
                        'label' => Yii::t('app', 'Date'),
                        'format' => ['date', 'php:d.m.Y G:i']
                    ],

                ]
            ]
        ); ?>
    </div>
</div>