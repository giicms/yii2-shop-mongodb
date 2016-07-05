<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use common\models\Category;
use yii\widgets\Menu;
use yii\helpers\Url;

class MenuWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $cart = !empty(Yii::$app->session->get('quantity')) ? Yii::$app->session->get('quantity') : "";
        $category = Category::find()->where(['level' => 0])->all();
        NavBar::begin([
            'brandLabel' => '',
            'brandUrl' => Yii::$app->homeUrl . 'cart',
            'options' => [
                'class' => 'navbar-inverse navbar-top',
            ],
        ]);
        $menuItems[] = ['label' => 'Blog', 'url' => ['/']];
        $menuItems[] = ['label' => 'Contact', 'url' => ['/']];
        $menuItems[] = [
            'label' => '<i class="fa fa-search" aria-hidden="true"></i>',
            'items' => [
                '<li>' .
                '<form class="form-inline" style="width:280px; padding:10px 20px;">
  <div class="form-group">
    <input type="text" class="form-control" id="inputPassword2" placeholder="Search keyword">
  </div>
  <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>'
                . '</li>',
            ],
            'options' => ['class' => 'dropdown-search']
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'SignUp', 'url' => ['/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::$app->user->identity->lastname . ' ' . Yii::$app->user->identity->firstname,
                'items' => [
                    '<li><a href="/profile">Profile</a></li>',
                    '<li><a href="/profile/changepassword">Change Password</a></li>',
                    '<li class="divider"></li>',
                    '<li>' . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                            'Logout', ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>',
                ],
            ];
        }
        $menuItems[] = '<li class="btn btn-danger btn-post"><a href="/cart/basket"><div class="numcart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>' . $cart . '</span></div></a></li>';
//        $menuItems[] = '<li class="btn btn-success btn-post"><a href="/post/create"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Post</a></li>';
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
            'encodeLabels' => false
        ]);
        NavBar::end();
        ?>
        <header class="cd-main-header">
            <a class="cd-logo" href="<?= \Yii::$app->homeUrl ?>">
                <img src="<?= Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->view->theme->baseUrl . '/images/large_logo.svg']) ?>" alt="Logo">
            </a>
            <ul class="cd-header-buttons">
                <li><a class="cd-nav-trigger" href="#cd-primary-nav">Menu<span></span></a></li>
            </ul> <!-- cd-header-buttons -->

        </header>

        <main class="cd-main-content">
            <!-- your content here -->
        </main>
        <div class="cd-overlay"></div>
        <nav class="cd-nav">
            <ul id="cd-primary-nav" class="cd-primary-nav is-fixed">
                <?php
                if (!empty($category)) {
                    foreach ($category as $value) {
                        ?>
                        <li class="has-children">
                            <a href="javascript:void(0)"><?= $value->title ?></a>
                            <?php
                            $level1 = Category::find()->where(['parent_id' => $value->id])->all();
                            if (!empty($level1)) {
                                ?>

                                <ul class="cd-secondary-nav is-hidden">
                                    <li class="go-back"><a href="#0">Menu</a></li>
                                    <li class="see-all"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $value->slug]) ?>">All <?= $value->title ?></a></li>
                                    <?php
                                    if (!empty($level1)) {
                                        foreach ($level1 as $l1) {
                                            ?>

                                            <li class="has-children">
                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $l1->slug]) ?>"><?= $l1->title ?></a>

                                                <ul class="is-hidden">
                                                    <?php
                                                    $level2 = Category::find()->where(['parent_id' => $l1->id])->all();
                                                    if (!empty($level2)) {
                                                        foreach ($level2 as $l2) {
                                                            ?>

                                                            <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $l2->slug]) ?>"><?= $l2->title ?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </li>


                                            <?php
                                        }
                                    }
                                    ?>

                                </ul>                                        
                                <?php
                            }
                            ?>
                        </li>
                        <?php
                    }
                }
                ?>


            </ul> <!-- primary-nav -->
        </nav> <!-- cd-nav -->
        <?php
    }

}
?>
