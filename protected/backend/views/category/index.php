<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
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
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->getIndent($data->level) . $data->title;
                            }
                        ],
                        'slug',
                        'type',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->status == Category::STATUS_PUBLISH)
                                    $check = 'checked';
                                else
                                    $check = '';
                                return '<input type="checkbox" id="checkstatus" name="status" ' . $check . '>';
                            },
                        ],
                        ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('$("[name=status]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=status]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["category/status"]) . '", data: {id: key,state:state}, success: function (data) {
   
            }, });
});
') ?>
