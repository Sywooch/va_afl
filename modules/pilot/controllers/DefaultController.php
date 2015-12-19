<?php

namespace app\modules\pilot\controllers;

use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
    public function actionProfile($id)
    {
        return $this->render('profile',[
            'user' => Users::find()->andWhere(['vid'=>$id])->one()
        ]);
    }
    public function actionEdit($id)
    {
        if (!$id) {
            $user = Users::getAuthUser();
        } else {
            $user = Users::find()->andWhere(['vid' => $id])->one();
            if (!$user) {
                throw new \yii\web\HttpException(404, 'User not found');
            }
        }
        $user->scenario = Users::SCENARIO_EDIT;


        if ($user->load(Yii::$app->request->post())) {
            if ($user->avatar = UploadedFile::getInstance($user, 'avatar')) {
                if (in_array($user->avatar->extension, ['gif', 'png','jpg'])) {
                    $dir = Yii::getAlias('@app/web/img/avatars/');
                    $extension = $user->avatar->extension;
                    $user->avatar->name = md5($user->avatar->baseName);
                    $user->avatar->saveAs($dir . $user->avatar->name . "." .$extension);
                    $user->avatar = $user->avatar->name . "." . $extension;
                }
            }
            if(!$user->validate())
            {
                throw new \yii\web\HttpException(404, 'be');
            }
            $user->save();
            return $this->redirect(['profile', 'id' => $user->vid]);
        } else {
            return $this->render('edit', ['user' => $user]);
        }
    }
}
