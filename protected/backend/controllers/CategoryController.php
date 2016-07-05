<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BackendController {

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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex() {
        $items = $this->categories();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->title);
            $category = Category::findOne($model->parent_id);
            if (!empty($category))
                $model->level = $category->level + 1;
            else
                $model->level = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                return $this->redirect(['create']);
            }
        }
        if (!empty($model->parent_id))
            $model->parent_id = $model->parent_id;
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->title);
            $category = Category::findOne($model->parent_id);
            if (!empty($category))
                $model->level = $category->level + 1;
            else
                $model->level = 0;
            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Category::findOne($_POST['id']);
        if ($_POST['state'] == 'true') {
            $model->status = Category::STATUS_PUBLISH;
        } else {
            $model->status = Category::STATUS_PRIVATE;
        }
        $model->save();
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function categories(&$data = [], $parent = "") {
        $category = Category::find()->where(['parent_id' => $parent])->all();
        foreach ($category as $key => $value) {
            $data[] = $value;
            unset($category[$key]);
            $this->categories($data, $value->id);
        }
        return $data;
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
