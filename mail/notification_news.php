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

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <p>Hello, <?= Html::encode($user->full_name) ?>!</p>
                            <p>Sometimes all you want is to send a simple HTML email with a basic design.</p>
                            <h1>New news only for you! </h1>
                            <p>This is a really simple email template. Its sole purpose is to get you to click the button below.</p>
                            <h2><?= $content->name_en ?></h2>
                            <p><?= $content->description_en ?></p>
                            <!-- button -->
                            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <a href="http://dev.va-aeroflot.su/">View more info</a>
                                    </td>
                                </tr>
                            </table>
                            <!-- /button -->
                            <p>Feel free to use, copy, modify this email template as you wish.</p>
                            <p>Thanks, have a lovely day.</p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td></td>
    </tr>
</table>
<!-- /body -->

<!-- footer -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>Don't like these annoying emails? <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td></td>
    </tr>
</table>

