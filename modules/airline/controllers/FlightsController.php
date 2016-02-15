<?php

namespace app\modules\airline\controllers;

use Yii;
use yii\base\View;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Flights;
use yii\widgets\DetailView;

/**
 * FightController implements the CRUD actions for Flights model.
 */
class FlightsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    /**
     * Lists all Flights models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $query = $id ? Flights::find()->where(['user_id' => $id])->orderBy(['id' => SORT_DESC]) : Flights::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render(
            'view',
            [
                'user_id' => $id,
                'dataProvider' => $dataProvider,
                'from_view' => false,
            ]
        );
    }

    /**
     * Displays a single Flights model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $query = Flights::find()->where(['user_id' => $model->user_id])->andWhere(['status' => 2])->orderBy(
            ['id' => SORT_DESC]
        );

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render(
            'view',
            [
                'user_id' => $model->user_id,
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Updates an existing Flights model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update',
                [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionMapdata($id = null)
    {
        echo Flights::prepareTrackerData($id);
    }

    public function actionDetails($id = null)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('details', ['model' => $model]);
    }

    /**
     * Finds the Flights model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flights the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flights::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}