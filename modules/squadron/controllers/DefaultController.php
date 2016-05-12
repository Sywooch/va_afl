<?php

namespace app\modules\squadron\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Fleet;
use app\models\Flights;
use app\models\Content;
use app\models\Squadrons;
use app\models\SquadronUsers;
use app\models\Users;
use app\models\Log;

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
        $squadron = $this->findModel($id);

        $membersProvider = new ActiveDataProvider([
            'query' => SquadronUsers::find()->where(['squadron_id' => $id])->orderBy(['user_id' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $activeMembersProvider = new ActiveDataProvider([
            'query' => SquadronUsers::find()->where(['squadron_id' => $id])
                    ->andWhere(['status' => SquadronUsers::STATUS_ACTIVE])
                    ->orderBy(['status' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $flightsProvider = new ActiveDataProvider([
            'query' => Flights::find()->joinWith('fleet')->where('fleet.squadron_id = ' . $id)->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $fleetProvider = new ActiveDataProvider([
            'query' => Fleet::find()->where(['squadron_id' => $id])->orderBy(['id' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $documentsProvider = new ActiveDataProvider([
            'query' => Content::find()->joinWith('categoryInfo')->where(
                    'content_categories.link = ' . "'" . $squadron->abbr . "_documents'"
                )->orderBy(['id' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $logProvider = Yii::$app->user->can("squadrons/{$squadron->abbr}/log") ? new ActiveDataProvider([
            'query' => Log::find()->where(['type' => 'squads'])->andWhere(['sub_type' => $id]),
        ]) : null;

        return $this->render('view', [
            'squadron' => $squadron,
            'membersProvider' => $membersProvider,
            'activeMembersProvider' => $activeMembersProvider,
            'fleetProvider' => $fleetProvider,
            'flightsProvider' => $flightsProvider,
            'logProvider' => $logProvider,
            'user' => Users::getAuthUser(),
            'news' => Content::find()->joinWith('categoryInfo')->where('content_categories.link = ' . "'" . $squadron->abbr . "_news'")->limit(10)->all(),
                'documentsProvider' => $documentsProvider,
            ]
        );
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
                    //var_dump($member->errors);
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
                Log::action($user_id, 'delete', 'squads', $squadron_id);
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
                $member->accepted = gmdate('Y-m-d H:i:s');
                $member->accepted_by = Yii::$app->user->id;

                if (!$member->update()) {
                    //var_dump($member->errors);
                } else {
                    Log::action($user_id, 'accept', 'squads', $squadron_id);
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
                   //var_dump($member->errors);
                } else {
                    Log::action($user_id, 'suspend', 'squads', $squadron_id);
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
                    //var_dump($member->errors);
                } else {
                    Log::action($user_id, 'unlock', 'squads', $squadron_id);
                }
            }
        }
        return $this->redirect(['view', 'id' => $squadron_id]);
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
