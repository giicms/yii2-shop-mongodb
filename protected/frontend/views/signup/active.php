<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Active';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-8 col-sm-offset-2">
                <p>Đăng ký thành công. Hãy vào mail để kích hoạt tài khoản.</p>
            </div>
        </div>
    </div>
</section>