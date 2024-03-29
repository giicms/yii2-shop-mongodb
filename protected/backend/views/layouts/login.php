<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

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

        <div class="login-box">
            <div class="login-logo">
                <a href="<?= Yii::$app->homeUrl ?>"><b>LOGO</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <?= $content ?>

            </div>
            <!-- /.login-box-body -->
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
