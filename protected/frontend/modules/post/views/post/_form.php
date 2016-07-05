<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'category_id')->dropDownList($model->categories, ['multiple' => TRUE]) ?>
    <div class="form-group">
        <label class="control-label">Content</label>
    </div>
    <?= $form->field($model, 'content')->textarea()->label(FALSE) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=
$this->registerJs('
$("#post-category_id").select2({
      placeholder: "Choose Categories"
});
new SimpleMDE({
		element: document.getElementById("post-content"),
		spellChecker: true,
	});
');
?>
