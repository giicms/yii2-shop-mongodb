<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>

<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary','style'=>'widt:100%', 'name' => 'login-button']) ?>
    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/site/forgetpassword']) ?>" class="pull-right">I forgot my password</a>
</div>

<?php ActiveForm::end(); ?>

<!-- /.social-auth-links -->

