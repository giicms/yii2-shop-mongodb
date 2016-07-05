<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\Blog;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class BlogController extends BackendController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['type' => 'blog']),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Blog();
        if ($model->load(Yii::$app->request->post())) {
            $category = Category::findOne($model->category_id);
            $arr = [];
            if ($category->level == 2) {
                $level_1 = Category::findOne($category->parent_id);
                $level = Category::findOne($level_1->parent_id);
                $arr[0] = $level->id;
                $arr[1] = $level_1->id;
                $arr[2] = $category->id;
            } else if ($category->level == 1) {
                $level = Category::findOne($category->parent_id);
                $arr[0] = $level->id;
                $arr[1] = $category->id;
            } else {
                $arr[0] = $category->id;
            }
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->cats = $arr;
            if (!empty($_POST['img']))
                $model->images = $_POST['img'];
            $model->user_id = \Yii::$app->user->id;
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $post = $this->findModel($id);
        $model = new Blog();

        $model->attributes = $post->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $post->attributes = $model->attributes;
            $category = Category::findOne($model->category_id);
            $arr = [];
            if ($category->level == 2) {
                $level_1 = Category::findOne($category->parent_id);
                $level = Category::findOne($level_1->parent_id);
                $arr[0] = $level->id;
                $arr[1] = $level_1->id;
                $arr[2] = $category->id;
            } else if ($category->level == 1) {
                $level = Category::findOne($category->parent_id);
                $arr[0] = $level->id;
                $arr[1] = $category->id;
            } else {
                $arr[0] = $category->id;
            }
            $post->slug = \Yii::$app->convert->string($model->title);
               if (!empty($_POST['img']))
                $model->images = $_POST['img'];
            $post->cats = $arr;
            $post->user_id = \Yii::$app->user->id;
            $post->save();
            return $this->redirect(['view', 'id' => $post->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
