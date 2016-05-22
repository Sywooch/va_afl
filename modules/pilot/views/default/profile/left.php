<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 23.05.16
 * Time: 1:39
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Html::beginTag('div', ['class' => 'profile-image']) ?>

<?php
if (isset($user->avatar) && file_exists(Yii::getAlias('@app/web/img/avatars/') . $user->avatar)) {
    echo Html::img('/img/avatars/' . $user->avatar);
} else {
    echo Html::img('/img/avatars/default.png');
} ?>

<?= Html::tag('i', '', ['class' => 'fa fa-user hide']) ?>
<?= Html::endTag('div') ?>
<div class="">
    <ul class="list-group nopoints">
        <li class="list-group-item list-group-item-<?= $user->pilot->statusType; ?>">
            <?= $user->pilot->statusName; ?>
        </li>
        <!--<li class="list-group-item list-group-item-warning" style="background-color: #FDEBD1;">
            Supervisor
        </li>
        <li class="list-group-item list-group-item">
            Examiner
        </li>
        <li class="list-group-item list-group-item">
            Trainer
        </li>-->
        <?php foreach($staff as $pos):?>
            <li class="list-group-item list-group-item">
                <a href="/airline/staff/view/<?= $pos->id?>"><?= $pos->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php echo $user->online ? Html::tag(
    'span',
    'Online',
    ['class' => 'label label-success']
) : Html::tag(
    'span',
    'Offline',
    ['class' => 'label label-default']
) ?>