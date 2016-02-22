<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 20.02.16
 * Time: 6:31
 */
?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Events') ?></h4>
    </div>
    <div class="panel-body">
            <?=
            \talma\widgets\FullCalendar::widget(
                [
                    'googleCalendar' => false,
                    'config' => [
                        'lang' => Yii::$app->language == 'RU' ? 'ru' : 'en',
                        'events' => $eventsCalendar
                    ],
                ]
            ); ?>
    </div>
</div>
<!-- end panel -->