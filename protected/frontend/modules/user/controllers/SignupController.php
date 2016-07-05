<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use frontend\modules\user\models\SignupForm;

/**
 * Site controller
 */
class SignupController extends Controller {

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionIndex() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
