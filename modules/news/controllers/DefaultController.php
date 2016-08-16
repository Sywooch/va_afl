<?php

namespace app\modules\news\controllers;

use app\models\ContentCategories;
use yii\web\Controller;

use app\models\Content;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{
    public function actionIndex($id = null)
    {
        return $this->render(
            'index',
            [
                'content' => $id == null ? Content::news() : Content::newsCategory($id),
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
