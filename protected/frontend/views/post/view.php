<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\web\Session;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use frontend\components\widgets\SnapshotWidget;

$session = Yii::$app->session;
$session->get('cart');
$this->title = $model->title;
if (!empty($categories)) {
    foreach ($categories as $value) {
        $this->params['breadcrumbs'][] = ['label' => $value['title'], 'url' => ['/category/' . $value['slug']]];
    }
}
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->convert->excerpt($model->content, 150)
]);
$this->registerLinkTag([
    'rel' => 'prev',
    'title' => $model->title,
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug])
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug])
]);
$this->registerLinkTag([
    'rel' => 'shortlink',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug])
]);
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
        <div class="product-detail">
            <div class="row">
                <div class="col-lg-4">
                    <div class="large-img">
                        <img src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/' . $model->images[0]]) ?>">
                    </div>
                    <?php
                    if (!empty($model->images) && count($model->images) > 1) {
                        ?>
                        <div class="small-img">
                            <?php
                            foreach ($model->images as $image) {
                                ?>
                                <img style="width: 25%" src="/uploads/thumbs/<?= $image ?>" data="<?= $image ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-lg-8">
                    <h2><?= $model->title ?></h2>
                    <p>              
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $model->category->slug]) ?>"><i class="fa fa-align-justify" aria-hidden="true"></i> <?= $model->category->title ?></a>, 

                        <span><i class="fa fa-clock-o"></i> <?= date('F j, Y', $model->updated_at) ?></span>
                    </p>
                    <div style="height:35px;">
                        <div class="star">
                            <span class="rating-stars-off">★★★★★</span> 
                            <span class="rating-stars-on" style="width:<?= ($model->countRating * 10) > 0 ? $model->countRating * 10 : 12 ?>%">★★★★★</span> 

                        </div>
                    </div>
                    <div>
                        <?= number_format($model->price, 0, '', '.') ?> VND
                    </div>
                    <div class="addcart">
                        <a href="javascript:void(0)" class="btn btn-danger add-detail add_<?= $model->id ?>" data="0"  style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "none" : "block" ?>">
                            Add cart
                        </a>
                        <div class="empty empty_<?= $model->id ?>" style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "block" : "none" ?>">
                            <span class="btn btn-danger addto-detail" data="1">-</span>
                            <span class="quantity"><?php
                                if (!empty($_SESSION['cart'][$model->id]['quantity']))
                                    echo $_SESSION['cart'][$model->id]['quantity']
                                    ?></span>
                            <span class="btn btn-danger addto-detail" data="2">+</span>
                        </div>
                    </div>
                    <p>
                        <?= $model->content ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="product-later">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="category-title">
                        Reviews
                        <small class="pull-right">
                            <a href="javascript:void(0)" class="write-review" data="<?= $model->id ?>"><?= !empty($model->review) ? 'Edit your review' : 'Write a review' ?></a>
                        </small>
                    </h2>
                </div>
                <div class="col-sm-8">
                    <?= SnapshotWidget::widget(['id' => $model->id, 'star' => 5]) ?>
                    <?= SnapshotWidget::widget(['id' => $model->id, 'star' => 4]) ?>
                    <?= SnapshotWidget::widget(['id' => $model->id, 'star' => 3]) ?>
                    <?= SnapshotWidget::widget(['id' => $model->id, 'star' => 2]) ?>
                    <?= SnapshotWidget::widget(['id' => $model->id, 'star' => 1]) ?>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-2">
                            Overall:  
                        </div>
                        <div class="col-sm-3">
                            <div class="star">
                                <span class="rating-stars-off">★★★★★</span> 
                                <span class="rating-stars-on" style="width:<?= $model->countRating * 10 ?>%">★★★★★</span> 

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <span><?= $model->countRating ?></span></div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="category-title">
                    You might also like to try...
                </h2>
            </div>
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
</section>
<?= $this->registerJs('
$(".add-detail").on("click", function(event, state) {
    var key = "' . $model->id . '";
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
$(".addto-detail").on("click", function(event, state) {
    var key = "' . $model->id . '";
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
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
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
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
$(".small-img img").on("click", function(event, state) {
    var data = $(this).attr("data");
    var src = "/products/"+data;
    $(".large-img img").attr("src",src);
});
') ?>
<?=
$this->registerJs("$(document).on('click', '.write-review', function (event){
        event.preventDefault();
        var id = $(this).attr('data');
            $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/review"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
              $('#modal').modal('show');
              $('#modal').find('.modal-body').html(data); 
            }
        });
      
});");
?>
<?= $this->registerJs("$(document).on('submit', '#formReview', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/review"]) . "',
            type: 'post',
            data: $('form#formReview').serialize(),
            success: function(data) {
            if(data){
            $('.form-review').html(data);
                }
            }
        });

});") ?>
<?= $this->registerJs("$(document).on('submit', '#login', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["login/ajax"]) . "',
            type: 'post',
            data: $('form#login').serialize(),
            success: function(data) {
                if(data=='ok'){
                    window.location.href = '" . $_SERVER['REQUEST_URI'] . "'; 
                }
            }
        });

});") ?>
<?php
echo $this->registerJs("$(document).on('click', '.modal-close', function (event){
        event.preventDefault();
        window.location.href = '" . $_SERVER['REQUEST_URI'] . "'; 
});");
?>

<div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">    
    <div class="modal-dialog <?= (Yii::$app->user->isGuest) ? "modal-login" : "" ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?=(Yii::$app->user->isGuest)?"Login":"Rate & Review"?></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>   
