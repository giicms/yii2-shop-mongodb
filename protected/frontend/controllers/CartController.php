<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\web\Session;
use common\models\Post;
use common\models\Order;

class CartController extends Controller {

    public function actionAdd() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = Post::findOne($_POST['id']);
        if ($_POST['act'] == 2) {
            $total = Yii::$app->session->get('quantity') + 1;
            $quantity = Yii::$app->session['cart'][$_POST['id']]['quantity'] + 1;
            $price = $model->price * $quantity;
        } elseif ($_POST['act'] == 1) {
            $total = Yii::$app->session->get('quantity') - 1;
            $quantity = Yii::$app->session['cart'][$_POST['id']]['quantity'] - 1;
            $price = $model->price * $quantity;
        } else {
            $total = Yii::$app->session->get('quantity') + 1;
            $quantity = 1;
            $price = $model->price * $quantity;
        }
        if ($quantity > 0) {
            $item = [
                "name" => $model->title,
                "image" => $model->images[0],
                "quantity" => $quantity,
                "price" => $price,
            ];
            $cartArray = Yii::$app->session['cart'];
            $cartArray[$model->id] = $item;
            Yii::$app->session['cart'] = $cartArray;
        } else {
            if (!empty($_SESSION['cart'][$_POST['id']])) {
                unset($_SESSION['cart'][$_POST['id']]);
            }
        }
        Yii::$app->session['quantity'] = $total;
        return ['quantity' => $quantity, 'total' => $total];
    }

    public function actionBasket() {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $model = new Order();
        $model->status = 1;
        if ($model->load(Yii::$app->request->post())) {
            $data = [];
            if (!empty($cart)) {
                foreach ($cart as $key => $value) {
                    $data[] = ['image' => $value['image'], 'name' => $value['name'], 'quantity' => $value['quantity'], 'price' => $value['price']];
                }
            }
            $model->products = $data;
            if ($model->save())
                return $this->redirect(['order', 'id' => $model->id]);
        }

        return $this->render('basket', ['cart' => $cart, 'model' => $model]);
    }

    public function actionRemove($id) {

        $session = Yii::$app->session;
        $session->get('cart');
        if (!empty($_SESSION['cart'][$id])) {
            $total = Yii::$app->session->get('quantity') - $_SESSION['cart'][$id]['quantity'];
            Yii::$app->session['quantity'] = $total;
            unset($_SESSION['cart'][$id]);
        } else {
            throw new NotFoundHttpException('This page does not exist in the system.');
        }
        return $this->redirect(['basket']);
    }

    public function actionOrder($id) {
        $model = Order::findOne($id);
        return $this->render('order', ['model' => $model]);
    }

    public function actionCheckout() {
        $cart = Yii::$app->session->get('cart');
        $order = new Order();
        if (!Yii::$app->user->isGuest) {
            $user = \common\models\User::findOne(Yii::$app->user->id);
            $order->attributes = $user->attributes;
            $order->name = $user->lastname . ' ' . $user->firstname;
        }
        return $this->render('checkout', ['model' => $order,'cart'=>$cart]);
    }

}
