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
           'query'=>Users::find()->joinWith('pilot')->joinWith('pilot.rank')->andWhere('active=1')
        ]);
        $dataProvider->sort->attributes['pilot.location']= ['asc'=>['user_pilot.location'=>SORT_ASC],'desc'=>['user_pilot.location'=>SORT_DESC]];
        $dataProvider->sort->attributes['pilot.rank.name_en']= ['asc'=>['ranks.name_en'=>SORT_ASC],'desc'=>['ranks.name_en'=>SORT_DESC]];
        $dataProvider->sort->attributes['pilot.rank.name_ru']= ['asc'=>['ranks.name_ru'=>SORT_ASC],'desc'=>['ranks.name_ru'=>SORT_DESC]];

        return $this->render('roster',['dataProvider'=>$dataProvider]);
    }
}
