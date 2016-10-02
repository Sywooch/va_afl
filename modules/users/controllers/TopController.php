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
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Top models.
     * @param int $month
     * @param int $year
     * @return mixed
     */
    public function actionMonth($month = 0, $year = 0)
    {
        $searchModel = new TopSearch();
        if($month == 0 && $year == 0){
            $month = gmdate("m");
            $year = gmdate("Y");
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Top::byMonth($month, $year));

        return $this->render('month', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
