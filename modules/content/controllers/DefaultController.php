<?php

namespace app\modules\content\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

use app\models\Content;
use app\models\ContentCategories;

class DefaultController extends Controller
{
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Content::find(),
        ]);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->can('content/edit') && (!Yii::$app->user->can(
                    $model->categoryInfo->access_read
                ) && !empty($model->categoryInfo->access_read))
        ) {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        return $this->render(
            'view',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new Content();
        $model->author = Yii::$app->user->identity->vid;

        if ($model->load(Yii::$app->request->post())){
            if (!Yii::$app->user->can('content/edit')
            && (!Yii::$app->user->can($model->categoryInfo->access_edit) && !empty($model->categoryInfo->access_edit)))
            {
                throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
            }

            if (UploadedFile::getInstance($model, 'img')) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if (in_array($model->img->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/news/');
                    $extension = $model->img->extension;
                    $model->img->name = md5($model->img->baseName);
                    $model->img->saveAs($dir . $model->img->name . "." . $extension);
                    $model->img = $model->img->name . "." . $extension;
                }
            }

            if (UploadedFile::getInstance($model, 'preview')) {
                $model->preview = UploadedFile::getInstance($model, 'preview');
                if (in_array($model->preview->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/news/preview');
                    $extension = $model->preview->extension;
                    $model->preview->name = md5($model->preview->baseName);
                    $model->preview->saveAs($dir . $model->preview->name . "." . $extension);
                    $model->preview = $model->preview->name . "." . $extension;
                }
            }

            $model->save();
            return $this->redirect(['view/' . $model->id]);
        } else{
            return $this->render(
            'create',
            [
                'model' => $model,
            ]
        );
         }
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->can('content/edit')
            && (!Yii::$app->user->can($model->categoryInfo->access_edit) && !empty($model->categoryInfo->access_edit)))
        {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        if ($model->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($model, 'img')) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if (in_array($model->img->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/news/');
                    $extension = $model->img->extension;
                    $model->img->name = md5($model->img->baseName);
                    $model->img->saveAs($dir . $model->img->name . "." . $extension);
                    $model->img = $model->img->name . "." . $extension;
                }
            }

            if (UploadedFile::getInstance($model, 'preview')) {
                $model->preview = UploadedFile::getInstance($model, 'preview');
                if (in_array($model->preview->extension, ['gif', 'png', 'jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/news/preview/');
                    $extension = $model->preview->extension;
                    $model->preview->name = md5($model->preview->baseName);
                    $model->preview->saveAs($dir . $model->preview->name . "." . $extension);
                    $model->preview = $model->preview->name . "." . $extension;
                }
            }
            $model->update();
            return $this->redirect(['view/' . $model->id]);
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
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->can('content/edit')
            && (!Yii::$app->user->can($model->categoryInfo->access_edit) && !empty($model->categoryInfo->access_edit)))
        {
            throw new \yii\web\HttpException(403, Yii::t('app', 'Forbidden'));
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
