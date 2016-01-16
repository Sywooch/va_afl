<?php

namespace app\modules\squadron\controllers;

use app\models\Squadrons;
use app\models\SquadronUsers;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Squads model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Squads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Squadrons::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Squads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $membersProvider = new ActiveDataProvider([
            'query' => SquadronUsers::find()->where(['squadron_id' => $id])/*->andWhere(['status' => SquadronUsers::STATUS_ACTIVE])*/
            ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'squadron' => $this->findModel($id),
            'membersProvider' => $membersProvider,
            'user' => Users::getAuthUser(),
        ]);
    }

    /**
     * Creates a new Squads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Squadrons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Squads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionJoin()
    {
        $squadron_id = Yii::$app->request->post('squadron');
        if (isset($squadron_id)) {
            $squadron = $this->findModel($squadron_id);
            if (!$squadron->getSquadronMembers()->where(['user_id' => Yii::$app->user->id])->one()) {
                $member = new SquadronUsers();
                $member->user_id = Yii::$app->user->id;
                $member->squadron_id = $squadron->id;
                $member->status = SquadronUsers::STATUS_PENDING;
                if (!$member->save()) {
                    var_dump($member->errors);
                }
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
    }

    public function actionMemberdelete()
    {
        $squadron_id = Yii::$app->request->post('squadron');
        $user_id = Yii::$app->request->post('user_id');
        if ($squadron_id && $user_id) {
            $squadron = $this->findModel($squadron_id);
            $member = $squadron->getSquadronMembers()->where([
                'user_id' => $user_id
            ])->one();
            if (isset($member)) {
                $member->delete();
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
    }

    public function actionAccept()
    {
        $squadron_id = Yii::$app->request->post('squadron');
        $user_id = Yii::$app->request->post('user_id');
        if ($squadron_id && $user_id) {
            $squadron = $this->findModel($squadron_id);
            $member = $squadron->getSquadronMembers()->where([
                'user_id' => $user_id,
                'status' => SquadronUsers::STATUS_PENDING
            ])->one();
            if (isset($member)) {
                $member->status = SquadronUsers::STATUS_ACTIVE;
                if (!$member->update()) {
                    var_dump($member->errors);
                }
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
    }

    public function actionSuspend()
    {
        $squadron_id = Yii::$app->request->post('squadron');
        $user_id = Yii::$app->request->post('user_id');
        if ($squadron_id && $user_id) {
            $squadron = $this->findModel($squadron_id);
            $member = $squadron->getSquadronMembers()->where([
                'user_id' => $user_id,
                'status' => SquadronUsers::STATUS_ACTIVE
            ])->one();
            if (isset($member)) {
                $member->status = SquadronUsers::STATUS_SUSPENDED;
                if (!$member->update()) {
                    var_dump($member->errors);
                }
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
    }

    public function actionUnlock()
    {
        $squadron_id = Yii::$app->request->post('squadron');
        $user_id = Yii::$app->request->post('user_id');
        if ($squadron_id && $user_id) {
            $squadron = $this->findModel($squadron_id);
            $member = $squadron->getSquadronMembers()->where([
                'user_id' => $user_id,
                'status' => SquadronUsers::STATUS_SUSPENDED
            ])->one();
            if (isset($member)) {
                $member->status = SquadronUsers::STATUS_ACTIVE;
                if (!$member->update()) {
                    var_dump($member->errors);
                }
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
    }

    /**
     * Deletes an existing Squads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Squads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Squadrons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Squadrons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
