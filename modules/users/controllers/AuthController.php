<?php

namespace app\modules\users\controllers;

use app\models\IvaoLogin;
use app\models\UserPilot;
use app\models\Users;
use yii\web\Controller;
use app\models\EmailConfirm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii;

/**
 * Default controller for the `users` module
 */
class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
            return $this->redirect(Yii::$app->params['ivao_login_url']);
        }
        $model = new IvaoLogin();
        if ($model->login($IVAOTOKEN) == false) {
            return $this->redirect('registration?IVAOTOKEN=' . $IVAOTOKEN);
        }
        if (Yii::$app->user->identity->status == UserPilot::STATUS_PENDING) {
            return 1;
        } else {
            return $this->goHome();
        }
    }

    public function actionRegistration($IVAOTOKEN)
    {
        if (Yii::$app->request->isPost) {
            $ivaologin = new IvaoLogin();
            $ivaologin->register($_POST, $IVAOTOKEN);
            return $this->redirect('login?IVAOTOKEN=' . $IVAOTOKEN);
        } else {
            $this->layout = '/registration';
            return $this->render('registration',
                [
                    'IVAOTOKEN' => $IVAOTOKEN
                ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionConfirmtoken($id)
    {
        try {
            $model = new EmailConfirm($id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            $this->goHome();
        } else {
            throw new HttpException('500');
        }
    }
}
