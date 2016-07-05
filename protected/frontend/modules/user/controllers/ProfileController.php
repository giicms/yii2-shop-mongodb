<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use frontend\modules\user\models\User;

/**
 * Site controller
 */
class ProfileController extends Controller {

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionIndex() {
        $model = User::findOne(Yii::$app->user->id);
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
