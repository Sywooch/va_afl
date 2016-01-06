<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 04.10.15
 * Time: 15:08
 */

use kartik\select2\Select2;
use yii\web\JsExpression;
use \kartik\depdrop\DepDrop;
use yii\helpers\Url;
use \yii\widgets\Pjax;

$this->title = Yii::t('app', 'Booking');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
];
?>

<?php if (!$model->id): ?>
    <div class="row">
        <div class="col-md-12">
            <h1><?= Yii::t('app', 'Booking') ?></h1>
        </div>
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('booking', 'Booking details') ?></h4>
                </div>
                <div class="panel-body" style="height: 500px">
                    <?php
                    //Нет букинга - показываем форму
                    $form = \yii\widgets\ActiveForm::begin(['id' => 'booking']);
                    //далее элементы формы
                    ?>
                    <?= $form->field($model, 'callsign')->textInput(); ?>
                    <?=
                    $form->field($model, 'from_icao')->textInput(['readonly' => true]);
                    ?>
                    <?=
                    $form->field($model, 'to_icao')->widget(
                        Select2::classname(),
                        [
                            'options' => ['placeholder' => 'Search for an airport...'],
                            'pluginOptions' => [
                                'ajax' => [
                                    'url' => \yii\helpers\Url::to('/site/getairports'),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ]
                    );
                    ?>
                    <?=
                    $form->field($model, 'aircraft_type')->widget(
                        Select2::classname(),
                        [
                            'options' => ['id' => 'aircraft_type', 'placeholder' => 'Search for an aircraft type...'],
                            'pluginOptions' => [
                                'ajax' => [
                                    'url' => \yii\helpers\Url::to('/site/getacftypes'),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ]
                    );
                    ?>
                    <?=
                    $form->field($model, 'fleet_regnum')->widget(
                        DepDrop::classname(),
                        [
                            'options' => ['id' => 'fleet_regnum',],
                            'type' => DepDrop::TYPE_SELECT2,
                            'pluginOptions' => [
                                'depends' => ['aircraft_type'],
                                'placeholder' => 'Select...',
                                'url' => Url::to(['/site/getacfregnums'])
                            ]
                        ]
                    );
                    ?>
                    <?= \yii\helpers\Html::submitButton(Yii::t('booking', 'Book'), ['class' => 'btn btn-success']); ?>

                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h2 class="panel-title"><?= Yii::t('booking', 'Available flights in schedule') ?></h2>
                </div>
                <div class="panel-body" style="height: 500px;">
                    <?php
                    Pjax::begin();
                    echo \yii\grid\GridView::widget(
                        [
                            'dataProvider' => $scheduledp,
                            'layout' => '{items}{pager}',
                            'columns' => [
                                ['attribute' => 'flight', 'options' => ['style' => 'width: 20px;']],
                                [
                                    'options' => ['style' => 'width: 90px;'],
                                    'attribute' => 'dep',
                                    'format' => 'html',
                                    'value' => function ($data) {
                                            return "<div><img src='" . $data->departure->flaglink . "'/>$data->dep</div>";
                                        }
                                ],
                                [
                                    'options' => ['style' => 'width: 90px;'],
                                    'attribute' => 'arr',
                                    'format' => 'html',
                                    'value' => function ($data) {
                                            return "<div><img src='" . $data->arrival->flaglink . "'/>$data->arr</div>";
                                        }
                                ],
                                'aircraft',
                                [
                                    'attribute' => 'dep_utc_time',
                                    'value' => function ($data) {
                                            return date('H:i', strtotime($data->dep_utc_time));
                                        }
                                ],
                                [
                                    'attribute' => 'arr_utc_time',
                                    'value' => function ($data) {
                                            return date('H:i', strtotime($data->arr_utc_time));
                                        }
                                ],
                            ]
                        ]
                    );
                    Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
else:
//Есть букинг - показываем его
    ?>
    <div class="row">
        <div class="jumbotron" style="padding: 10px;">
            <h1 class="text-center"><?= $model->callsign ?></h1>
            <?=
            \yii\widgets\DetailView::widget(
                [
                    'model' => $model,
                    'template' => '<tr><td style="width: 50%;">{label}</td><td>{value}</td></tr>',
                    'attributes' => [
                        'from_icao' => [
                            'label' => Yii::t('flights', 'Departure airport'),
                            'value' => '<img src="' . $model->arrival->flaglink . '">' . $model->from_icao,
                            'format' => 'html'
                        ],
                        'to_icao' => [
                            'label' => Yii::t('flights', 'Arrival airport'),
                            'value' => '<img src="' . $model->departure->flaglink . '">' . $model->to_icao,
                            'format' => 'html'
                        ],
                        'aircraft_type',
                        'fleet_regnum' => [
                            'label' => Yii::t('flights', 'Aircraft Registration Number'),
                            'value' => \app\models\Fleet::findOne($model->fleet_regnum) ? \app\models\Fleet::findOne(
                                    $model->fleet_regnum
                                )->regnum : ''
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
            ) ?>
            <?php
            echo \yii\helpers\Html::a(
                \yii\bootstrap\Html::button(Yii::t('booking', 'Delete'), ['class' => 'btn btn-danger']),
                Url::to('/site/deletemybooking')
            );
            ?>
        </div>
    </div>
<?php endif; ?>