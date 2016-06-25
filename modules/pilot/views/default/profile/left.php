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
        <table class="table table-condensed">
            <tbody>
            <tr>
            <tr class="<?= $user->pilot->statusType; ?>">
                <td><?= $user->pilot->statusName; ?> User</td>
            </tr>
            <?php if (Yii::$app->authManager->checkAccess($user->vid, 'supervisor')): ?>
                <tr class="warning">
                    <td>AFL Group Supervisor</td>
                </tr>
            <?php endif; ?>
            <?php /*?>
            <?php if (Yii::$app->authManager->checkAccess($user->vid, 'training/examiner')): ?>
                <tr>
                    <td>AFL Group Examiner</td>
                </tr>
            <?php endif; ?>
            <?php if (Yii::$app->authManager->checkAccess($user->vid, 'training/trainer')): ?>
                <tr>
                    <td>AFL Group Trainer</td>
                </tr>
            <?php endif; ?>
            <?php */ ?>
            <?php foreach ($staff as $pos): ?>
                <tr>
                    <td>
                        <?php // <a href="/airline/staff/view/<?= $pos->id ?>
                        <?= $pos->name_en ?>
                        <?php // </a> ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php foreach ($squadrons as $pos): ?>
                <tr>
                    <td>
                        <a href="/squadron/view/<?= $pos->squadron_id ?>">Member of <?= $pos->squadron->name_en ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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