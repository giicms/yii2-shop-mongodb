<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                Pjax::begin([
                    'id' => 'pjax_gridview_post',
                ])
                ?>
                <?=
                GridView::widget([
                    'id' => 'girdPost',
                    'dataProvider' => $dataProvider,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'images',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return '<img width="50" src="/uploads/thumbs/' . $data->images[0] . '">';
                            }
                        ],
                        'title',
                        [
                            'attribute' => 'category_id',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->category->title;
                            }
                        ],
                        [
                            'attribute' => 'price',
                            'format' => 'raw',
                            'value' => function($data) {
                                return number_format($data->price, 0, '', '.');
                            }
                        ],
                        [
                            'attribute' => 'user_id',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->user->username;
                            }
                        ],
                        // 'publish',
                        // 'created_at',
                        // 'updated_at',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
                <?php Pjax::end() ?> 
            </div>
        </div>
    </div>
</div>

<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#girdPost").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn mở các mẫu tin này không (s)");
        };
     
    if (msg == true) {
     if(keys!=""){
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["post/updates"]) . '", data: {ids: keys}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });
         }
    }
    return false;
});

');
?>
