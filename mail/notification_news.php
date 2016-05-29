<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 28.05.16
 * Time: 19:41
 */

use yii\helpers\Html;

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

                            <h2><?= $content->name_en ?></h2>

                            <p><?= $content->description_en ?></p>
                            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <a href="http://dev.va-aeroflot.su/">View more info</a>
                                    </td>
                                </tr>
                            </table>
                            <p>Have a safety flights with us.</p>

                            <p>Stay tuned,</p>

                            <p>AFL GROUP Team</p>
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
                        <td align="center">
                            <p>Don't like these annoying emails? <a href="#">
                                    <unsubscribe>Unsubscribe</unsubscribe>
                                </a>.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>