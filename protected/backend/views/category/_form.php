<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    'offset' => 'col-sm-offset-2',
                    'wrapper' => ' col-md-6 col-sm-6 col-xs-12',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);
?> 
<?= $form->field($model, 'title') ?>

<?= $form->field($model, 'parent_id')->dropDownList($model->getCategories(), ['prompt' => 'Choose the category']) ?>

<?= $form->field($model, 'type')->dropDownList($model->types) ?>
<div class="form-group">
    <label class="control-label col-sm-2" for="category-images">Images</label>
    <div class="col-sm-6 ">
        <div class="row">
            <div class="col-sm-4">
                <div class="post-upload">
                    <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 
                </div>
            </div>
            <div class="col-sm-4 img-list">
                <?php
                if (!empty($model->images)) {
                    ?>
                    <div class="img_1">
                        <div class="img-tem">
                            <img class="img-rounded"  style="width:100px" src="/uploads/thumbs/<?= $model->images ?>"> 
                            <input type="hidden" name="image" value="<?= $model->images ?>"> 
                            <a class="deleteFile" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?= $form->field($model, 'images')->hiddenInput()->label(FALSE) ?>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        <div>
            <?= Html::submitButton('Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?=
$this->registerJs('
$("#category-parent_id").select2({
      placeholder: "Choose Parent"
});
');
?>
<?=
$this->registerJs('$(document).ready(function ()
{

      $("#upload").uploadFile({
        url: "' . Yii::$app->urlManager->createUrl(["upload/multiple"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: true,
       onBeforeSend: function () {
            $(".loading-img").html("�?ang tải...");
        },

             onSuccess: function (files, data, xhr)
        {
                    $(".loading-img").html("");
            $.each(data, function (index, value) {
            $("#category-images").val(value[0].name);
               $(".img-list").html("<div class=\"img_1 \"><div class=\"img-tem\"><img class=\"img-rounded\"  style=\"width:100px\" src="+value[0].url+"> <input type=\"hidden\" name=\"img\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ data-img="+value[0].name+"><i class=\"fa fa-trash-o\"></i></a></div></div>");
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".img-project").html("Không đúng định dạng hoặc size quá lớn");
        }
    });
 $(document).on("click", ".deleteFile", function () {
        var comfirm = confirm("Bạn có muốn xóa cái file không");
        var id =$(this).attr("id");
        if(comfirm){
          $(".img_1").remove();
   
        }
    });
})');
?>