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

class CategoryWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $category = Category::find()->where(['level' => 0])->all();
        ?>

        <?php
        if (!empty($category)) {
            foreach ($category as $value) {
                $level1 = Category::find()->where(['parent_id' => $value->id])->all();
                ?>

                <?php
                if (!empty($level1)) {
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3><?= $value->title ?></h3>
                        </div>
                        <?php
                        if (!empty($level1)) {
                            foreach ($level1 as $l1) {
                                ?>
                                <div class="col-sm-3">
                                    <h4><?= $l1->title ?></h4>
                                    <ul class="list-unstyled list-item">
                                        <?php
                                        $level2 = Category::find()->where(['parent_id' => $l1->id])->all();
                                        if (!empty($level2)) {
                                            foreach ($level2 as $l2) {
                                                ?>

                                                <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/post/create/' . $l2->id]) ?>"><?= $l2->title ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $value->slug]) ?>"><h4><?= $value->title ?></h4></a>
                        </div>
                    </div>

                    <?php
                }
            }
        }
        ?>
        <?php
    }

}
