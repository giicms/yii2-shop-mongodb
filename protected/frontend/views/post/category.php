<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use frontend\components\Categories;

$this->title = !empty($category) ? $category->title : 'Apps Games';
if (!empty($categories)) {
    foreach ($categories as $value) {
        $this->params['breadcrumbs'][] = ['label' => $value['title'], 'url' => ['/category/' . $value['slug']]];
    }
}
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?=
                Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Home'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?php
                Categories::lists($category->id);
                ?>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <?=
                    ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'tag' => 'div',
                            'class' => 'list-wrapper',
                            'id' => 'list-wrapper',
                        ],
                        'layout' => "{items}\n<div class=\"col-sm-12 text-center\">{pager}</div>",
                        'itemView' => '_item',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->registerJs('
$(".add").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
                $(".quantity").text(data.quantity);
                $(".add_"+key).hide();
                $(".empty_"+key).show();
                if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>

<?= $this->registerJs('
$(".addto").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
               if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
            }, 
        });
});
') ?>

