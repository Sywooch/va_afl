<?php

namespace app\modules\airline\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
