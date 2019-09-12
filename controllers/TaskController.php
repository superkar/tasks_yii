<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\Tag;
use app\models\TaskHasTag;
use yii\data\ActiveDataProvider;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends BaseController
{
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->id]),
        ]);
        
        $dataProvider->setSort([
            'defaultOrder' => ['status' => SORT_ASC, 'priority' => SORT_DESC]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            if ($model->save()) {
                $tags_parts = explode(',', $model->tags);
                foreach ($tags_parts as $tag) {
                    $model_tag = Tag::find()->where(['title' => trim($tag)])->one();
                    if (!$model_tag) {
                        $model_tag = new Tag();
                        $model_tag->title = trim($tag);
                        $model_tag->save();
                    }
                    $model_task_tag = new TaskHasTag();
                    $model_task_tag->task_id = $model->id;
                    $model_task_tag->tag_id = $model_tag->id;
                    $model_task_tag->save();
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            TaskHasTag::deleteAll(['task_id' => $model->id]);
            $tags_parts = explode(',', $model->tags);
            foreach ($tags_parts as $tag) {
                $model_tag = Tag::find()->where(['title' => trim($tag)])->one();
                if (!$model_tag) {
                    $model_tag = new Tag();
                    $model_tag->title = trim($tag);
                    $model_tag->save();
                }
                $model_task_tag = new TaskHasTag();
                $model_task_tag->task_id = $model->id;
                $model_task_tag->tag_id = $model_tag->id;
                $model_task_tag->save();
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
