<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use frontend\models\SignupForm;

/**
 * Site controller
 */
class SignupController extends Controller {

    public function actionIndex() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('signup', 'ok');
                return $this->redirect(['active']);
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionActive() {
        if (!empty(Yii::$app->session->getFlash('signup'))) {
            return $this->render('active');
        }
    }

}
