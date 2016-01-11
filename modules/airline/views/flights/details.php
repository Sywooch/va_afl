<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 12.01.16
 * Time: 1:07
 */
$data = ['callsign'=>$model->callsign,
    'html'=>
    //TODO: все дела красота
\yii\widgets\DetailView::widget(
    [
        'model' => $model,
        'options' => ['class'=>'table table-bordered table-condensed'],
        'attributes' => [
            'callsign',
            'user_id',
            'first_seen',
            'last_seen',
            'from_icao',
            'to_icao',
        ],
    ]
)];
echo json_encode($data);
?>