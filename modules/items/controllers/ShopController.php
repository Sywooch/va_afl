<?php

namespace app\modules\items\controllers;

class ShopController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPurchases()
    {
        return $this->render('purchases');
    }

    public function actionSlots()
    {
        return $this->render('slots');
    }

}
