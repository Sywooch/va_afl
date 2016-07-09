<?php

namespace app\modules\users\controllers;

use app\models\IvaoLogin;
use app\models\UserPilot;
use app\models\Users;
use yii\web\Controller;
use app\models\EmailConfirm;
use app\components\EmailSender;
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

    public function actionLogin($redirect_url = null, $IVAOTOKEN = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!$IVAOTOKEN) {
           if($redirect_url == null)
            {
                return $this->redirect(Yii::$app->params['ivao_login_url'] . '/users/auth/login?redirect_url=null');
            } else {
                return $this->redirect(Yii::$app->params['ivao_login_url'] . '/users/auth/login?redirect_url='.$redirect_url);
            }
        }
        $model = new IvaoLogin();
        if ($model->login($IVAOTOKEN) == false) {
            if($redirect_url == null)
            {
                return $this->redirect('registration?IVAOTOKEN=' . $IVAOTOKEN);
            } else {
                return $this->redirect('/site/index'); //TODO: тут нужно показать страницу о том, что пользователю зарегистрироваться для продолжения
            }
        }
        if (Yii::$app->user->identity->status == UserPilot::STATUS_PENDING) {
            return $this->redirect('confirmemail');
        } else {
            if($redirect_url == null)
            {
                Yii::trace($redirect_url);
                return $this->goHome();

            } else {
                return $this->redirect($redirect_url);
            }
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
        Yii::trace('12345');

        if ($model->confirmEmail()) {
            $this->goHome();
        } else {
            throw new HttpException('500');
        }
    }

    public function actionConfirmemail()
    {
        if (Yii::$app->request->isPost) {
            $user = Users::getAuthUser();
            if (isset($_POST['email']))
            {
                $user->email = $_POST['email'];
            }
            $token = Yii::$app->security->generateRandomString();
            $user->email_token = $token;
            $user->save();
            EmailSender::sendConfirmationMail($user, $token);
        }
        $this->layout = '/registration';
        return $this->render('confirm_email');
    }
}
