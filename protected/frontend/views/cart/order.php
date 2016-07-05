<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;

$this->title = 'Information Order';
?>
<section class="page">
    <div class="container">
        <h2 class="category-title"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> Information Order</h2>
        <?php
        if (!empty($model)) {
            ?>
            <div class="order-info">
                <div class="row">
                    <div class="col-sm-6">
                        <dl class="dl-horizontal dl-order">
                            <dt>Name</dt><dd><?= $model->name ?></dd>
                            <dt>Email</dt><dd><?= $model->email ?></dd>
                            <dt>Phone</dt><dd><?= $model->phone ?></dd>
                            <dt>Address</dt><dd><?= $model->address ?>, <?= $model->city ?></dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="dl-horizontal dl-order">
                            <dt>Code orders</dt><dd><?= $model->id ?></dd>
                            <dt>Total</dt><dd><?= number_format($model->total, 0, '', '.') ?> VND</dd>
                            <dt>Date</dt><dd><?= date('d/m/Y h:i', $model->created_at) ?></dd>
                            <dt>Status</dt><dd>
                                <?php
                                if ($model->status == 1)
                                    echo '<span class="btn btn-danger">Unpaid</span>';
                                else
                                    echo '<span class="btn btn-success">Paid</span>';
                                ?>
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
            <?php
            $q = 0;
            $price = 0;
            $stt = 1;
            foreach ($model->products as $key => $value) {

                $q += $value['quantity'];
                $price +=$value['price'];
                ?>
                <div class="cart-item" data-key="<?= $key ?>">
                    <div class="row">
                        <div class="col-sm-1">
                            <?= $stt++ ?>
                        </div>
                        <div class="col-sm-2">
                            <img style="width: 60px" src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/thumbs/' . $value['image']]) ?>">
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
                    </div>

                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-4">
                    Total
                </div>
                <div class="col-sm-2">
                    <?= $q ?>
                </div>
                <div class="col-sm-2">
                    <?= number_format($price, 0, '', '.') ?> VND
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</section>