<?php

namespace app\modules\fleet\controllers;

use app\models\Actypes;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'paxbycraft') {
            # code...
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPaxbycraft()
    {
        $model = Actypes::find()->all();
        foreach ($model as $item) {
            if(isset($_POST['pax_'.$item->code])){
                $item->max_pax = $_POST['pax_'.$item->code];
                $item->save();
            }
        }
        $model = Actypes::find()->all();
        return $this->render('paxbycraft',['model'=>$model]);
    }
}

