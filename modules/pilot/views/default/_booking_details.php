<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 09.01.16
 * Time: 16:19
 */
use app\models\Pax;
echo \yii\widgets\DetailView::widget(
    [
        'model' => $model,
        'options'=>['class'=>'table condensed bordered'],
        'template' => '<tr><td style="width: 50%;">{label}</td><td>{value}</td></tr>',
        'attributes' => [
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
            'aircraft_type',
            'fleet_regnum' => [
                'label' => Yii::t('flights', 'Aircraft Registration Number'),
                'value' => \app\models\Fleet::findOne($model->fleet_regnum) ? \app\models\Fleet::findOne(
                    $model->fleet_regnum
                )->regnum : ''
            ],
            'pax' => [
                'label' => Yii::t('booking','Pax\'s'),
                'value' => Pax::appendPax($model->from_icao,$model->to_icao,$model->aircraft_type,$model->fleet)
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