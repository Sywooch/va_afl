<?php

namespace app\modules\screens\controllers;

use yii\web\Controller;

use app\models\Content;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $screens = Content::find()->where(['category' => 16])->all();
        return $this->render('index', ['screens' => $screens]);
    }
}
