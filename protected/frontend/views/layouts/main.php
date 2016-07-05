<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\widgets\MenuWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?= MenuWidget::widget() ?>
            <?= $content ?>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <ul class="list-unstyled">
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <ul class="list-unstyled">
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact">
                            <p>info@gicms.com</p>
                            <p>0905 951 699</p>
                            <p>Mon to Fri: 8.30am - 6pm</p>
                            <p>Sat: 9am - 5pm</p>
                            <p><?= Yii::powered() ?></p>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
