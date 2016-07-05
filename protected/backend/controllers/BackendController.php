<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;

class BackendController extends Controller {

    public function init() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        } else if (Yii::$app->user->identity->role != 'admin') {
            return $this->redirect(Yii::$app->homeUrl);
        }
    }

}
