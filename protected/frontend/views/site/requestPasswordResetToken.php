<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-8 col-sm-offset-2">
                <div class="row">
                    <div class="col-lg-8">
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
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                        <div class="form-group">
                            <div class=" col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
                                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>