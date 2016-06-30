<?php

namespace app\modules\users\controllers;

use app\models\IvaoLogin;
use yii\web\Controller;
use app\models\Users;
use Yii;

/**
 * Default controller for the `users` module
 */
class AuthController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionLogin($IVAOTOKEN = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!$IVAOTOKEN) {
            Yii::trace('1234');
            return $this->redirect(Yii::$app->params['ivao_login_url']);
        }
        $model = New IvaoLogin();
        if (!$model->login($IVAOTOKEN)) {
            return $this->redirect('register', ['IVAOTOKEN' => $IVAOTOKEN]);
        }
        return 1;
    }
}
