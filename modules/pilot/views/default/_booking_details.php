<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 09.01.16
 * Time: 16:19
 */
use app\models\Pax;
$paxes = Pax::appendPax($model->from_icao,$model->to_icao,$model->fleet);
echo \yii\widgets\DetailView::widget(
    [
        'model' => $model,
        'options'=>['class'=>'table condensed bordered'],
        'template' => '<tr><td style="width: 50%;">{label}</td><td>{value}</td></tr>',
        'attributes' => [
            'callsign',
            'from_icao' => [
                'label' => Yii::t('flights', 'Departure airport'),
                'value' => '<img src="' . $model->departure->flaglink . '">' . $model->from_icao,
                'format' => 'html'
            ],
            'to_icao' => [
                'label' => Yii::t('flights', 'Arrival airport'),
                'value' => '<img src="' . $model->arrival->flaglink . '">' . $model->to_icao,
                'format' => 'html'
            ],
            'fleet_regnum' => [
                'label' => Yii::t('flights', 'Aircraft Registration Number'),
                'value' => \app\models\Fleet::findOne($model->fleet_regnum) ? \app\models\Fleet::findOne(
                    $model->fleet_regnum
                )->regnum : ''
            ],
            'acf_type' => [
                'label' => Yii::t('flights', 'Aircraft type'),
                'value' => \app\models\Fleet::findOne($model->fleet_regnum)->type_code
            ],
            'pax' => [
                'label' => Yii::t('booking','Pax\'s'),
                'value' =>$paxes['total']
            ],
            'pax_red' => [
                'label' => Yii::t('booking','Pax\'s Red'),
                'value' =>$paxes['paxtypes']['red']
            ],
            'pax_yellow' => [
                'label' => Yii::t('booking','Pax\'s Yellow'),
                'value' =>$paxes['paxtypes']['yellow']
            ],
            'pax_green' => [
                'label' => Yii::t('booking','Pax\'s Green'),
                'value' =>$paxes['paxtypes']['green']
            ],
            'total_vucs' => [
                'label' => Yii::t('app','Total flight VUC\'s'),
                'format' => 'html',
                'value' => \app\models\Billing::calculatePriceForFlight($model->from_icao,$model->to_icao,$paxes['paxtypes'])."VUC"
            ],
            'distance' => [
                'label' => Yii::t('app','Distance'),
                'format' => 'html',
                'value' => \app\components\Helper::calculateDistanceLatLng($model->departure->lat,$model->arrival->lat,$model->departure->lon,$model->arrival->lon)
            ],
            'status' => [
                'label' => Yii::t('flights', 'Booking status'),
                'value' => $model->status == 1 ? Yii::t('booking', 'Ready') : Yii::t(
                    'booking',
                    'In progress'
                )
            ]
        ]
    ]

) ;
echo \yii\helpers\Html::a(
    \yii\bootstrap\Html::button(Yii::t('booking', 'Delete'), ['class' => 'btn btn-danger']),
    \yii\helpers\Url::to('/site/deletemybooking')
);
?>