<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use backend\models\Profile;
use backend\models\SignupForm;
use common\models\User;

/**
 * Site controller
 */
class UserController extends Controller {

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => 'member']),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id) {
        $user = User::findOne($id);
        $model = new Profile();
        $model->attributes = $user->attributes;
        if ($model->load(Yii::$app->request->post())) {
            if ($profile = $model->profile()) {
                Yii::$app->session->setFlash('success', 'Ban cap nhap profile ' . $model->lastname . ' ' . $model->firstname . ' thanh cong!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('profile', [
                    'model' => $model,
        ]);
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
