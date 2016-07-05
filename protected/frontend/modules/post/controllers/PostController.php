<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Category;
use common\models\Comment;

/**
 * Default controller for the `post` module
 */
class PostController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCreate() {
        $this->layout = 'post';
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->title);
            $arr = [];
            foreach ($model->category_id as $value) {
                $category = Category::findOne($value);
                $arr[] = ['id' => $category->id, 'title' => $category->title, 'slug' => $category->slug];
            }
            $model->category = $arr;
            if ($model->save())
                return $this->redirect(['post/view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $this->layout = 'post';
        $model = $this->findModel($id);
        foreach ($model->category_id as $cat) {
            $data[$cat] = $cat;
        }
        $model->category_id = $data;
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->title);
            if ($model->save())
                return $this->redirect(['post/view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionView($id) {
        $this->layout = 'post';
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['post_id' => $id]),
        ]);

        $comment = new Comment();
        $count = Comment::find()->where(['post_id' => $id])->count();
        if ($comment->load(Yii::$app->request->post())) {
            $comment->post_id = $id;
            if ($comment->save())
                return $this->redirect(['post/view', 'id' => $model->id]);
        }
        return $this->render('view', ['model' => $model, 'comment' => $comment, 'dataProvider' => $dataProvider, 'count' => $count]);
    }

    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
