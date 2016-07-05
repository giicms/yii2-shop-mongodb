<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-8 col-sm-offset-2">
                <div class="form-group">
                    <div class=" col-md-12 col-sm-12 col-xs-12">
                        <?= Alert::widget() ?>
                    </div>
                </div>
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

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'password_new')->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="form-group">
                    <div class=" col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
                        <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>