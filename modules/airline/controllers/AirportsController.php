<?php

namespace app\modules\airline\controllers;

use Yii;
use app\models\Airports;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AirportsController implements the CRUD actions for Airports model.
 */
class AirportsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['edit_airfield'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Airports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Airports;
        $params = \Yii::$app->request->get();

        $provider = $model->search($params);
        $provider->pagination = ['pageSize' => 100];
        $provider->sort->defaultOrder = ['id' => SORT_ASC];

        return $this->render(
            'index',
            [
                'dataProvider' => $provider,
                'model' => $model
            ]
        );
    }

    /**
     * Displays a single Airports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $key=preg_match('/^\d+$/',$id)?'id':'icao';
        return $this->render(
            'view',
            [
                'model' => $this->findModel([$key=>$id]),
            ]
        );
    }

    /**
     * Creates a new Airports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Airports();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'create',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Updates an existing Airports model.
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

    /**
     * Deletes an existing Airports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Airports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Airports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Airports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
