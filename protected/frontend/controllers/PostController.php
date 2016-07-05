<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Post;
use common\models\Category;
use common\models\Product;

/**
 * Site controller
 */
class PostController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $category = Category::find()->where(['level' => 0])->all();
        $model = new Product();
        if ($model->load(Yii::$app->request->post())) {
            $model->type = 'product';
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->price = (int) str_replace('.', '', $model->price);
            $model->images = $_POST['img'];
            $model->user_id = \Yii::$app->user->id;
            if ($model->save())
                return $this->redirect(['acrive', 'id' => $model->id]);
        }
        if (!empty($_GET['id'])) {
            $category = Category::findOne($_GET['id']);
            if (!empty($category)) {

                $model->category_id = $category->id;
                return $this->render('create', [
                            'category' => $category,
                            'model' => $model,
                            'step' => 2
                ]);
            } else {
                $this->redirect(['post/create']);
            }
        }

        return $this->render('create', [
                    'category' => $category,
                    'step' => 1
        ]);
    }

    public function actionCategory() {
        $category = Category::find()->where(['slug' => $_GET['slug']])->one();
        if (empty($category))
            throw new NotFoundHttpException('This page does not exist in the system.');
        if ($category->level == 2) {
            $level_1 = Category::findOne($category->parent_id);
            $model = Category::findOne($level_1->parent_id);
            $parent = [$model, $level_1];
        } elseif ($category->level == 1) {
            $model = Category::findOne($category->parent_id);
            $parent = [$model];
        } else {
            $parent = [];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['IN', 'cats', $category->id]),
        ]);

        return $this->render('category', [
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'categories' => $parent
        ]);
    }

    public function actionView() {

        $model = Post::find()->where(['slug' => $_GET['slug']])->one();
        if (empty($model))
            throw new NotFoundHttpException('This page does not exist in the system.');

        $category = Category::findOne($model->category_id);
        if ($category->level == 2) {
            $level_1 = Category::findOne($category->parent_id);
            $level = Category::findOne($level_1->parent_id);
            $parent = [$level, $level_1, $category];
        } elseif ($category->level == 1) {
            $level = Category::findOne($category->parent_id);
            $parent = [$level, $category];
        } else {
            $parent = [$category];
        }
        if (!empty($model->review))
            $review = $model->review;
        else {
            $review = new \common\models\Review();
            $review->star = 0;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['category_id' => $model->category_id])->andWhere(['NOT IN', '_id', $model->id]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('view', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'review' => $review,
                    'categories' => $parent
        ]);
    }

    public function actionActive($id) {

        $model = Post::findOne($id);
        return $this->render('active', [
                    'model' => $model
        ]);
    }

}
