<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\components\Convert;
use yii\web\Session;

$session = Yii::$app->session;
$session->get('cart');
?>



<div class="col-sm-3">
    <div class="product-item">
        <div class="product-img">
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug]) ?>">
                <img src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/thumbs/' . $model->images[0]]) ?>">

            </a>
        </div>
        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug]) ?>">
            <h4><?= $model->title ?></h4>
        </a>
        <div class="product-item-review">
            <div class="star">
                <span class="rating-stars-off">★★★★★</span> 
                <span class="rating-stars-on" style="width:<?= ($model->countRating * 10)>0?$model->countRating * 10:12 ?>%">★★★★★</span> 

            </div>
        </div>
        <div class="addcart">
            <ul class="list-inline">
                <li><?= number_format($model->price, 0, '', '.') ?> VND</li>
                <li>
                    <a href="javascript:void(0)" class="btn btn-danger add add_<?= $model->id ?>" data="0"  style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "none" : "block" ?>">
                        Add
                    </a>
                    <div class="empty empty_<?= $model->id ?>" style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "block" : "none" ?>">
                        <span class="btn btn-danger addto" data="1">-</span>
                        <span class="quantity"><?php
                            if (!empty($_SESSION['cart'][$model->id]['quantity']))
                                echo $_SESSION['cart'][$model->id]['quantity']
                                ?></span>
                        <span class="btn btn-danger addto" data="2">+</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</div>
