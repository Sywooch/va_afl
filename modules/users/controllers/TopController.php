<?php

namespace app\modules\users\controllers;

use app\models\Top\Top;
use Yii;
use app\models\Top\TopSearch;
use yii\web\Controller;

/**
 * TopController implements the CRUD actions for Top model.
 */
class TopController extends Controller
{
    /**
     * Lists all Top models.
     * @return mixed
     */
    public function actionAll()
    {
        $searchModel = new TopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Top::all());

        return $this->render('all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
