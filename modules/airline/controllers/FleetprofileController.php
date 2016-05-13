<?php

namespace app\modules\airline\controllers;

use app\models\Squadrons;
use Yii;
use app\models\FleetProfiles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FleetProfilesController implements the CRUD actions for FleetProfiles model.
 */
class FleetprofileController extends Controller
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


    public function actionStats()
    {
        $stats_t = Yii::$app->getDb()->createCommand(
            'SELECT fleet.squadron_id, count(DISTINCT id) as acoun, a.coun
                    FROM fleet
                    LEFT JOIN
                    (SELECT squadron_id, count(DISTINCT id) as coun FROM fleet WHERE profile IS NOT NULL GROUP BY fleet.squadron_id)
                    AS a ON a.squadron_id = fleet.squadron_id WHERE profile IS NULL AND fleet.squadron_id > 0 AND fleet.squadron_id < 4
                    GROUP BY fleet.squadron_id'
        )->queryAll();
        $stats = [];

        foreach($stats_t as $stat){
            $stats[Squadrons::findOne($stat['squadron_id'])->name_en][] = ['name' => 'Without profile', 'y' => (int) $stat['acoun']];
            $stats[Squadrons::findOne($stat['squadron_id'])->name_en][] = ['name' => 'With profile', 'y' => (int) $stat['coun']];
        }


        return $this->render('stats', [
                'stats' => $stats,
            ]);
    }

    /**
     * Lists all FleetProfiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FleetProfiles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FleetProfiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FleetProfiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FleetProfiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FleetProfiles model.
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

    /**
     * Deletes an existing FleetProfiles model.
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
     * Finds the FleetProfiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FleetProfiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FleetProfiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
