<?php

namespace app\modules\items\controllers;

use app\models\Items\ItemsTypes;
use app\modules\items\models\Shop;

class ShopController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['items' => Shop::all()]);
    }

    public function actionModal($id){
        return $this->renderAjax('modal', ['item' => ItemsTypes::findOne($id)]);
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
