<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 12.01.16
 * Time: 1:07
 */
$data = [
    'html' => Yii::$app->controller->renderPartial('fpl', ['model' => $model])
];
echo json_encode($data);
?>