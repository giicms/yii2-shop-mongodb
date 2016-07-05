<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Yii::$app->parsedown->text($model->content) ?>


</div>
<h4>Comment (<?=$count?>)</h4>
<div class="comment-list">
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => '_comment',
    ]);
    ?>
</div>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($comment, 'comment')->textarea()->label(FALSE) ?>
    <div class="form-group">
        <?= Html::submitButton($comment->isNewRecord ? 'Create' : 'Update', ['class' => $comment->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=
$this->registerJs('

new SimpleMDE({
		element: document.getElementById("comment-comment"),
		spellChecker: true,
	});
');
?>