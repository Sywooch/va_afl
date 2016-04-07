<?php

namespace app\modules\screens\controllers;

use yii\web\Controller;

use app\models\Content;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $screens = Content::find()->where(['category' => 16])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['screens' => $screens]);
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
