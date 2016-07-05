<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            '_id',
            [
                'label' => 'Tiêu đề',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data['name'], ['/post/category/' . $data['slug']]);
                }
                    ],
                    'slug',
                    'description',
                    'parent_id',
           
                    // 'created_at',
                    // 'updated_at',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
</div>
<?= $this->registerJs('$("[name=status]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=status]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["category/status"]) . '", data: {id: key,state:state}, success: function (data) {
   
            }, });
});
') ?>
