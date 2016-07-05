<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => ' col-md-10 col-sm-10 col-xs-12',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
    ]);
    ?> 


    <?= $form->field($model, 'category_id')->dropDownList($model->categories) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'content')->textarea(['class' => 'editor']) ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="row img-list">
                <?php
                if (!empty($model->images)) {
                    foreach ($model->images as $k => $value) {
                        ?>
                        <div class="col-md-2 col-sm-2 col-xs-4 img_<?= $k ?>">
                            <div class="img-tem">
                                <img class="img-rounded"  style="width:100px" src="/uploads/thumbs/<?= $value ?>"> 
                                <input type="hidden" name="img[]" value="<?= $value ?>"> 
                                <a class="deleteFile" href="javascript:void(0)" data-img="<?= $value ?>" id="<?= $k ?>"><i class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="post-upload">
                <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class=" pull-right">
                <?= Html::submitButton('Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=
$this->registerJs('
$("#product-category_id").select2({
      placeholder: "Choose Categories"
});
');
?>
<?= $this->registerJs('
$("#product-price").keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
  }

  $(this).val(function(index, value) {
    return value
      .replace(/\D/g, "")
      .replace(/([0-9])([0-9]{3})$/, "$1.$2")  
      .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")
    ;
  });
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
               $(".img-list").append("<div class=\"col-md-2 col-sm-2 col-xs-4 img_"+value[0].id+"\"><div class=\"img-tem\"><img class=\"img-rounded\"  style=\"width:100px\" src="+value[0].url+"> <input type=\"hidden\" name=\"img[]\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ data-img="+value[0].name+" id="+value[0].id+"><i class=\"fa fa-trash-o\"></i></a></div></div>");
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
          $(".img_"+id).remove();
   
        }
    });
})');
?>