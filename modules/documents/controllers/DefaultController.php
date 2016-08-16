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
                'content' => $id == null ? null : Content::documentsCategory($id)
            ]
        );
    }

    public function actionList($id)
    {
        return $this->render(
            'index',
            [
                'content' => Content::documentsCategory($id)
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
