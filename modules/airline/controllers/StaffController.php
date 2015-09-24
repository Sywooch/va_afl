<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.15
 * Time: 19:56
 */

namespace app\modules\airline\controllers;

use yii\web\Controller;
use app\models\Staff;
use yii\data\ActiveDataProvider;

class StaffController extends Controller
{
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Staff::find(),
            'sort' => false,
            'pagination' => false
        ]);
        return $this->render('list', ['dataProvider' => $provider]);
    }
}