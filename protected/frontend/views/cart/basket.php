<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;

$this->title = 'Basket';
?>
<section class="page">
    <div class="container">
        <h2 class="category-title"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> Basket</h2>
        <?php
        if (!empty($cart)) {
            $stt = 1;
            $price = 0;
            foreach ($cart as $key => $value) {
                $price += $value['price'];
                ?>
                <div class="cart-item" data-key="<?= $key ?>">
                    <div class="row">
                        <div class="col-sm-1">
                            <?= $stt++ ?>
                        </div>
                        <div class="col-sm-2">
                            <img style="width: 100px" src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/thumbs/' . $value['image']]) ?>">
                        </div>
                        <div class="col-sm-4">
                            <?= $value['name'] ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $value['quantity'] ?>
                        </div>
                        <div class="col-sm-2">
                            <?= number_format($value['price'], 0, '', '.') ?> VND
                        </div>
                        <div class="col-sm-1">
                            <a href="/cart/remove/<?= $key ?>" class="cart-remove">Remove</a>
                        </div>
                    </div>

                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-sm-2 col-lg-offset-10">
                    <div class="pull-right total-price">
                        Total : <span><?= number_format($price, 0, '', '.') ?> VNĐ</span>
                        <p>
                    
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/cart/checkout']) ?>" class="btn btn-danger">Checkout</a>
                       
                        </p>
                    </div>
                </div>
            </div>        
            <?php
        }
        ?>
    </div>

</section>