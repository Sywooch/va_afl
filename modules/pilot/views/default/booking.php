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

$this->title = Yii::t('app', 'Booking');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
];
?>

<?php if (!$model->id): ?>
    <div class="row">
        <div class="col-md-6">
            <?php
            //Нет букинга - показываем форму
            $form = \yii\widgets\ActiveForm::begin(
                [
                    'id' => 'profile'
                ]
            );
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
            <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Book')); ?>
            <?php
            \yii\widgets\ActiveForm::end();
            ?>
        </div>
        <div class="col-md-6">
            <pre>Тут должна быть таблица с расписанием</pre>
        </div>
    </div>
<?php
else:
//Есть букинг - показываем его
    \yii\helpers\VarDumper::dump($model->attributes, 10, true);
//И разрешаем удалить
    echo "<br>";
    echo \yii\helpers\Html::a(
        \yii\bootstrap\Html::button(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger']),
        Url::to('/site/deletemybooking')
    );
    ?>

<?php endif; ?>