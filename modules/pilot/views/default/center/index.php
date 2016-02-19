<?php
use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Pilot Center');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

?>
<div class="row">
    <?= $this->render('header', ['user' => $user]) ?>
</div>
<div class="row">
    <div class="col-md-8">
        <?= $this->render('onlinetable', ['onlineProvider' => $onlineProvider]) ?>
    </div>
    <div class="col-md-4">
        <!-- begin panel -->
    <?= $this->render('news', ['news' => $news]) ?>
    </div>
</div>
<div class="row">
    <!-- begin col-4 -->
    <div class="col-md-8">
        <?= $this->render('top', ['top' => $topProvider]) ?>
    </div>
    <!-- end col-4 -->
    <!-- begin col-4 -->
    <div class="col-md-4">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><?= Yii::t('app', 'Calendar') ?></h4>
            </div>
            <div class="panel-body">
                <?=
                \talma\widgets\FullCalendar::widget(
                    [
                        'googleCalendar' => false,
                        'config' => [
                            'lang' => Yii::$app->language == 'RU' ? 'ru' : 'en',
                            'events' => $events
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-4 -->
</div>
<?= Html::button('Launch edit profile',
    ['class' => 'btn btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#modal-dialog']) ?>

<?= $this->render('../edit_modal', ['user' => $user]) ?>