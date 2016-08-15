<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['users/auth/confirmtoken', 'id' => $token]);
?>
<table class="body-wrap" bgcolor="#f6f6f6">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <h1>Hello, <?= Html::encode($user->full_name) ?>!</h1>

                            <p>You are successfully registered in VA AFL </p>

                            <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>

                            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <a href="<?= $confirmLink ?>">Click here to confirm email</a>
                                    </td>
                                </tr>
                            </table>
                            <p>Have a safety flights with us.</p>

                            <p>Stay tuned,</p>

                            <p>VA AFL Team</p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">
            <div class="content">
                <table>
                    <tr>
                        <td align="center"></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>

