<?php

namespace app\modules\tours\controllers;

use app\models\Tours\Tours;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'tours' => Tours::find()->where(['status' => Tours::STATUS_ACTIVE])->all()
            ]
        );
    }

    public function actionView($id)
    {
        return $this->render(
            'view',
            [
                'tour' => Tours::find()->where(['id' => Tours::findOne($id)])
            ]
        );
    }
}
