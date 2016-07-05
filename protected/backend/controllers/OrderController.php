<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\Product;
use common\models\Post;
use common\models\Order;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class OrderController extends BackendController {

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
            'query' => Order::find(),
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
        $model = $this->findModel($id);
        $data = [];
        foreach ($model->products as $value) {
            $data[] = $value;
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [ 'name', 'quantity', 'price'],
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('view', [
                    'model' => $model,
                    'dataProvider' => $dataProvider
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
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
