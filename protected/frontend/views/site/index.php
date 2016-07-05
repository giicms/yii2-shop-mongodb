<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<section class="slide-main">
    <p class="title">
        A healthy & happy <br>way to eat
    </p>
    <p class="title-small">
        We bring boxes of organic <br>brilliance to your door
    </p>
</section>
<section class="secondary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"><h1>Hop on board for an ethical food adventure</h1></div>
            <div class="col-lg-4">
                <div class="img">
                    <img src="<?= Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->view->theme->baseUrl . '/images/choose-box.png']) ?>">
                </div>
                <h2>Choose a box</h2>
                <p>Returnable, recyclable packaging that'll stay chilled till you get home</p>

            </div>
            <div class="col-lg-4">
                <div class="img">
                    <img src="<?= Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->view->theme->baseUrl . '/images/vegetables.png']) ?>">
                </div>
                <h2>Make it perfect</h2>

                <p>Swap in and out what you fancy</p>

            </div>
            <div class="col-lg-4">
                <div class="img">
                    <img src="<?= Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->view->theme->baseUrl . '/images/driver.png']) ?>">
                </div>
                <h2>We deliver</h2>

                <p>On the same day each week
                    via eco routes</p>

            </div>
        </div>

    </div>
</section>
<section class="middle">
    <div class="container">
        <div class="row">
            <?php
            if (!empty($category)) {
                foreach ($category as $key => $value) {
                    ?>
                    <div class="col-lg-<?= ($key > 1 and $key < 5) ? 4 : 6 ?>">
                        <div class="item">
                            <div class="img">
                                <?php $img = ($key > 1 and $key < 5) ? 'main-box.jpg' : 'main-recipe.jpg' ?>
                                <img src="<?= Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->view->theme->baseUrl . '/images/' . $img]) ?>">
                            </div>
                            <div class="content-<?= ($key > 1 and $key < 5) ? 'green' : 'purple' ?>">
                                <h2><?= $value->title ?></h2>
                                <p>Returnable, recyclable packaging that'll stay chilled till you get home</p>
                                <p><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $value->slug]) ?>" class="btn btn-default">Choose your box</a></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </div>
</section>