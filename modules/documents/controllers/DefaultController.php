<?php

namespace app\modules\documents\controllers;

use app\models\ContentCategories;
use yii\web\Controller;

use app\models\Content;

/**
 * Default controller for the `documents` module
 */
class DefaultController extends Controller
{
    public function actionIndex($id = null)
    {
        return $this->render(
            'index',
            [
                'content' => $id == null ? false : Content::documentsCategory($id),
                'name' => $id == null ? '' : ContentCategories::findOne(['link' => $id])->name
            ]
        );
    }

    public function actionView($id)
    {
        return $this->render(
            'view',
            [
                'model' => Content::view($id),
            ]
        );
    }
}
