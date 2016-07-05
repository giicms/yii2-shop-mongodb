<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;
use common\models\User;

/**
 * Site controller
 */
class ProfileController extends Controller {

    public function actionIndex() {
        $user = User::findOne(\Yii::$app->user->id);
        $model = new Profile();
        $model->attributes = $user->attributes;
        if ($model->load(Yii::$app->request->post())) {
            if ($profile = $model->profile()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionChangepassword() {
        $model = new \frontend\models\ChangePassword();
        if ($model->load(Yii::$app->request->post())) {
            if ($profile = $model->change()) {
                Yii::$app->session->setFlash('success', 'You have successfully changed the password!');
                return $this->redirect(['changepassword']);
            }
        }

        return $this->render('changepassword', [
                    'model' => $model,
        ]);
    }

}
