<?php

namespace app\modules\content\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use app\models\Content;
use app\models\ContentCategories;
use app\models\ContentCategoriesSearch;

/**
 * ContentCategoriesController implements the CRUD actions for ContentCategories model.
 */
class CategoriesController extends Controller
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
        ];
    }

    /**
     * Lists all ContentCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContentCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single ContentCategories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $key = preg_match('/^\d+$/', $id) ? 'id' : 'link';
        $model = $this->findModel([$key => $id]);

        if (!Yii::$app->user->can($model->access_read) && !empty($model->access_read)) {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        return $this->render(
            'view',
            [
                'model' => $model,
                'content' => $model->content
            ]
        );
    }

    /**
     * Creates a new ContentCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ContentCategories();

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
     * Updates an existing ContentCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->can('content/edit') && !Yii::$app->user->can($model->access_edit)) {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

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
     * Deletes an existing ContentCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->can('content/edit') && !Yii::$app->user->can($model->access_edit)) {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ContentCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentCategories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
