<?php

namespace app\modules\pilot\controllers;

use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEditprofile()
	{
        if (!$model = Users::findOne(\Yii::$app->user->identity->vid)) {
            $model = new Users();
        }
        $model->scenario = Users::SCENARIO_EDIT;
        if (isset($_POST['Users'])) {
            $model->attributes=$_POST['Users'];
            $model->save();
            $this->refresh();
		}
        return $this->render('profile_editor', ['model' => $model]);
    }
    public function actionRoster()
    {
        $dataProvider = new ActiveDataProvider([
           'query'=>Users::find()->joinWith('pilot')->andWhere('active=1')
        ]);
        return $this->render('roster',['dataProvider'=>$dataProvider]);
    }
}
