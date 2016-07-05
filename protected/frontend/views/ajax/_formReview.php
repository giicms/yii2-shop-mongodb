<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\web\Session;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="form-review">
    <?php
    $form = ActiveForm::begin(['id' => 'formReview']);
    ?> 
    <div class="form-group">
        <?= Yii::$app->user->identity->lastname . ' ' . Yii::$app->user->identity->firstname ?>
    </div>
    <div class="form-group">
        <?= \frontend\components\widgets\RatingWidget::widget(['id' => $model->post_id, 'rating' => $model->star]) ?>
    </div>
    <?= $form->field($model, 'star')->hiddenInput()->label(FALSE) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(FALSE) ?>
    <?= $form->field($model, 'post_id')->hiddenInput()->label(FALSE) ?>
    <?= $form->field($model, 'content')->textarea()->label(FALSE) ?>

    <div class="text-right">
        <?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCE</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>