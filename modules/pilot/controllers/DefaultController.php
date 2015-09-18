<?php

namespace app\modules\pilot\controllers;

use app\models\Users;
use yii\web\Controller;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionEditprofile()
	{
		if (!$model = Users::findOne(\Yii::$app->user->identity->vid))
			$model = new Users();
		$model->scenario = Users::SCENARIO_EDIT;
		if (isset($_POST['Users'])) {
			$model->email = $_POST['Users']['email'];
			$model->save();
		}

		return $this->render('profile_editor', ['model' => $model]);
	}
}
