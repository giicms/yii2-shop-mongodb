<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;

$this->title = 'Payment';
?>
<section class="page">
    <div class="container">
        <h2 class="category-title"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> <?= $this->title ?></h2>
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-3',
                            'offset' => 'col-sm-offset-3',
                            'wrapper' => ' col-md-9 col-sm-9 col-xs-12',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
        ]);
        ?> 
        <div class="row">
            <div class="col-sm-6">

                <?= $form->field($model, 'name')->label() ?>
                <?= $form->field($model, 'phone')->label() ?>
                <?= $form->field($model, 'email')->label() ?>
                <?= $form->field($model, 'city')->label() ?>
                <?= $form->field($model, 'address')->label() ?>


            </div>
             <div class="col-sm-6">

                <?= $form->field($model, 'bank_name')->label() ?>
                <?= $form->field($model, 'bank_account')->label() ?>
                <?= $form->field($model, 'bank_address')->label() ?>
                <?= $form->field($model, 'note')->textarea() ?>


            </div>
            <div class="col-sm-12">
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

                    <?php
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-lg-offset-10">
                <div class="pull-right total-price">
                    Total : <span><?= number_format($price, 0, '', '.') ?> VNĐ</span>
                    <?= $form->field($model, 'total')->hiddenInput(['value' => $price])->label(FALSE) ?>
                    <button type="submit" class="btn btn-danger">Payment</button>
                </div>
            </div>
        </div> 
        <?php
        ActiveForm::end();
        ?>
    </div>

</section>