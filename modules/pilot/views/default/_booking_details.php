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
            'callsign',
            'from_icao' => [
                'label' => Yii::t('flights', 'Departure'),
                'value' => '<img src="' . $model->departure->flaglink . '">' . $model->from_icao,
                'format' => 'html'
            ],
            'to_icao' => [
                'label' => Yii::t('flights', 'Destination'),
                'value' => '<img src="' . $model->arrival->flaglink . '">' . $model->to_icao,
                'format' => 'html'
            ],
            'acf_type' => [
                'label' => Yii::t('flights', 'Aircraft'),
                'value' => \app\models\Fleet::findOne($model->fleet_regnum) ? \app\models\Fleet::findOne(
                        $model->fleet_regnum
                    )->full_type.' ('.\app\models\Fleet::findOne(
                            $model->fleet_regnum
                        )->type_code.')' : Yii::t('app', 'Unknown')
            ],
            'fleet_regnum' => [
                'label' => Yii::t('flights', 'Aircraft Registration Number'),
                'value' => \app\models\Fleet::findOne($model->fleet_regnum) ? \app\models\Fleet::findOne(
                    $model->fleet_regnum
                )->regnum : Yii::t('app', 'Unknown')
            ],
            'etd' => [
                'label' => Yii::t('flights', 'Estimated Time Departure'),
                'value' => $model->etd ? $model->etd : Yii::t('app', 'Unknown')
            ],
            'eet' => [
                'label' => Yii::t('flights', 'Estimated En-route Time'),
                'value' => $model->schedule ? $model->schedule->eet : Yii::t('app', 'Unknown')
            ],
            'pax' => [
                'label' => Yii::t('booking','Pax\'s'),
                'value' => !$model->flight ? Pax::appendPax($model->from_icao,$model->to_icao,$model->fleet)['total'] : $model->flight->pob
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
echo '<p>';
echo \yii\helpers\Html::a(
    \yii\bootstrap\Html::button(Yii::t('booking', 'Briefing'), ['class' => 'btn btn-success']),
    \yii\helpers\Url::to('/airline/flights/briefing'));
echo '</p><p>';
echo \yii\helpers\Html::a(
    \yii\bootstrap\Html::button(Yii::t('booking', 'Delete'), ['class' => 'btn btn-danger']),
    \yii\helpers\Url::to('/site/deletemybooking')
);
echo '</p>';
?>