<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Review;

/**
 * Site controller
 */
class AjaxController extends Controller {

    public function actionReview() {
        if (Yii::$app->user->isGuest) {
            return $this->renderAjax('/login/_ajax', ['model' => new \common\models\LoginForm()]);
        }

        if (!empty($_POST['id'])) {
            $post = Post::findOne($_POST['id']);
            if (!empty($post->review))
                $model = $post->review;
            else {
                $model = new Review();
                $model->user_id = Yii::$app->user->id;
                $model->post_id = $post->id;
                $model->star = 0;
            }
            return $this->renderAjax('_formReview', ['model' => $model]);
        } else {
            $post = Post::findOne($_POST['Review']['post_id']);
            if (!empty($post->review))
                $model = $post->review;
            else
                $model = new Review();

            $model->attributes = $_POST['Review'];
            if ($model->save()) {
                return $this->renderAjax('review', ['model' => Review::find()->where(['post_id' => $model->post_id])->all()]);
            }
        }
    }

}
