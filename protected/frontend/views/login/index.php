<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-8 col-sm-offset-2">
                <?php
                $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'label' => 'col-sm-3',
                                    'offset' => 'col-sm-offset-3',
                                    'wrapper' => ' col-md-6 col-sm-6 col-xs-12',
                                    'error' => '',
                                    'hint' => '',
                                ],
                            ],
                ]);
                ?> 

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <div class=" col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
