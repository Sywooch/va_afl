<?php

namespace app\modules\events\controllers;

use app\models\Events\Events;
use app\models\Events\EventsMembers;
use Yii;
use app\models\Events\EventsCategories;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for EventsCategories model.
 */
class CategoriesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'view', 'stats', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['events/stats'],
                    ],
                ]
            ]
        ];
    }

    public function actionStats($id)
    {
        $data = Events::find()->where([
            'id' => ArrayHelper::getColumn(EventsCategories::find()->where(['category_id' => $id])->all(), 'event_id')
        ])->orderBy('start asc')->all();
        return $this->render('stats', [
            'data' => $data
        ]);
    }

    public function actionFindevent($q = null)
    {
        echo Events::search($q);
    }

    /**
     * Lists all EventsCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EventsCategories::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventsCategories model.
     * @param integer $event_id
     * @param integer $category_id
     * @return mixed
     */
    public function actionView($event_id, $category_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($event_id, $category_id),
        ]);
    }

    /**
     * Finds the EventsCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $event_id
     * @param integer $category_id
     * @return EventsCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($event_id, $category_id)
    {
        if (($model = EventsCategories::findOne(['event_id' => $event_id, 'category_id' => $category_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new EventsCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::trace($_POST);
        if (isset($_POST['EventsCategories']['event_id'])) {

            if (is_array($_POST['EventsCategories']['event_id'])) {
                foreach ($_POST['EventsCategories']['event_id'] as $event) {
                    $model = new EventsCategories();
                    $model->event_id = $event;
                    $model->category_id = $_POST['EventsCategories']['category_id'];
                    $model->save();
                }
                return $this->redirect(['stats', 'id' => $_POST['EventsCategories']['category_id']]);
            } else {
                $model = new EventsCategories();
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect([
                        'view',
                        'event_id' => $model->event_id,
                        'category_id' => $model->category_id
                    ]);

                }
            }
        } else {
            $model = new EventsCategories();

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EventsCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $event_id
     * @param integer $category_id
     * @return mixed
     */
    public function actionUpdate($event_id, $category_id)
    {
        $model = $this->findModel($event_id, $category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'event_id' => $model->event_id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EventsCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $event_id
     * @param integer $category_id
     * @return mixed
     */
    public function actionDelete($event_id, $category_id)
    {
        $this->findModel($event_id, $category_id)->delete();

        return $this->redirect(['index']);
    }
}
