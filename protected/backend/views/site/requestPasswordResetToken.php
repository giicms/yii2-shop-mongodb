<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin();
?> 
<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

<div class="form-group">

        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
 
</div>

<?php ActiveForm::end(); ?>
