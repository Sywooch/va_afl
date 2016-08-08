<?php

namespace app\modules\items\controllers;

use app\models\Items\Items;

class ShopController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['items' => Items::shop()]);
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
