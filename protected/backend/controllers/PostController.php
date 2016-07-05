<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\Product;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BackendController {

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
            'query' => Post::find()->where(['type' => 'product']),
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
        $model = new Product();
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
            $model->type = 'product';
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->price = (int) str_replace('.', '', $model->price);
            $model->cats = $arr;
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
        $model = new Product();
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
            $post->title = $model->title;
            $post->slug = \Yii::$app->convert->string($model->title);
            $post->price = (int) str_replace('.', '', $model->price);
            $post->content = $model->content;
            $post->images = $_POST['img'];
            $post->cats = $arr;
            $post->user_id = \Yii::$app->user->id;
            $post->category_id = $model->category_id;
            
            if ($post->save())
                return $this->redirect(['view', 'id' => $post->id]);
        }
        $model->attributes = $post->attributes;
        $model->price = number_format($post->price, 0, '', '.');
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionUpdates() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $value) {
                $model = $this->findModel($value);
                $array = explode('|', $model->cats);
                $catid = [];
                if (!empty($array)) {
                    foreach ($array as $cat) {
                        $slug = Yii::$app->convert->string($cat);
                        $category = Category::find()->where(['slug' => $slug])->one();
                        if (!empty($category))
                            $catid[] = $category->id;
                    }
                }
                $model->cat_id = $catid;
                $model->slug = Yii::$app->convert->string($model->name);
                $model->save();
            }
        }

        return 'ok';
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
