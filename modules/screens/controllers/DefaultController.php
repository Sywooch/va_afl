<?php

namespace app\modules\screens\controllers;

use app\components\Levels;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\models\Content;
use app\models\Users;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $screens = Content::find()->where(['category' => 16])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['screens' => $screens, 'title' => \Yii::t('app', 'Feed')]);
    }

    public function actionUser($id)
    {
        $screens = Content::find()->where(['category' => 16])->andWhere(['author' => $id])->orderBy(
            ['id' => SORT_DESC]
        )->all();
        return $this->render(
            'index',
            ['screens' => $screens, 'title' => \Yii::t('app', 'of') . ' ' . Users::getUserName($id)]
        );
    }

    public function actionTop()
    {
        $screens = Content::find()->where(['category' => 16])->orderBy(['views' => SORT_DESC])->limit(20)->all();
        return $this->render('index', ['screens' => $screens, 'title' => \YIi::t('screens', 'Top') . 20]);
    }

    public function actionCreate()
    {
        $model = new Content();
        $model->category = 16;
        $model->author = \Yii::$app->user->identity->vid;
        $model->machine_name = null;

        if ($model->load(\Yii::$app->request->post())) {
            $model->name_ru = $model->name_en;
            $img = UploadedFile::getInstance($model, 'img_file');
            if (isset($img)) {
                if ($img->size !== 0 && in_array($img->extension, ['gif', 'png', 'jpg'])) {
                    $extension = $img->extension;
                    $img->name = md5($img->baseName);
                    if ($img->saveAs(\Yii::getAlias('@app/web/img/content/') . $img->name . "." . $extension)) {
                        $model->img = $img->name . "." . $extension;
                    }
                } else {
                    $model->img = null;
                }
            }

            if ($model->validate()) {
                $model->save();
                Levels::addExp(5, \Yii::$app->user->identity->vid);
            } else {
                throw new \yii\web\HttpException(500, \Yii::t('app', 'Error'));
            }

            return $this->redirect(['view/' . $model->id]);
        } else {
            return $this->render(
                'create',
                [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->views++;
        $model->save();

        return $this->render(
            'view',
            [
                'model' => $model,
            ]
        );
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (($model->author != \Yii::$app->user->identity->vid) && (!\Yii::$app->user->can('content/edit'))
            && (!\Yii::$app->user->can($model->categoryInfo->access_edit)
            && !empty($model->categoryInfo->access_edit))
        ) {
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
        if (Content::find()->where(['category' => 16, 'id' => $id])->one() == true) {
            return Content::findOne($id);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
