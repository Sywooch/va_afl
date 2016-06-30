<?php

namespace app\modules\airline\controllers;

use app\components\Levels;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Airports;

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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['airports/edit'],
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
        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
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
            Levels::addExp(10, \Yii::$app->user->identity->vid);
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
            Levels::addExp(5, \Yii::$app->user->identity->vid);
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

    public function actionInfo($id){
        $model = $this->findModel($id);
        return json_encode(
            [
                'icao' => $model->icao,
                'name' => $model->name,
                'latitude' => $model->lat,
                'longitude' => $model->lon
            ]);
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
        $key = preg_match('/^\d+$/', $id) ? 'id' : 'icao';
        if (($model = Airports::findOne([$key => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
