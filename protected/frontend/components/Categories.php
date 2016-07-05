<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;
use common\models\Category;

class Categories extends Component {

    public static function lists($id) {
        $category = Category::findOne($id);
        $data = [];
        if ($category->level == 2) {
            $level_1 = Category::findOne($category->parent_id);
            $model = Category::findOne($level_1->parent_id);
            $parent = $model->id;
        } elseif ($category->level == 1) {
            $model = Category::findOne($category->parent_id);
            $parent = $model->id;
        } else {
            $parent = $category->id;
        }
        $model = Category::findOne($parent);
        echo '<ul class="list-unstyled list-item">';

        echo '<li><a href="' . Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $model->slug]) . '">' . Categories::indent($model->level) . $model->title . '</a></li>';
        Categories::parents($data, $model->id);

        echo '</ur>';
    }

    public static function parents(&$data = [], $parent = "") {
        $category = Category::find()->where(['parent_id' => $parent])->all();
        echo '<ul class="list-unstyled list-item">';
        foreach ($category as $key => $value) {
            echo '<li><a href="' . Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $value->slug]) . '">' . Categories::indent($value->level) . $value->title . '</a></li>';
            unset($category[$key]);
            Categories::parents($data, $value->id);
        }
        echo '</ur>';
    }

    public static function indent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '&nbsp;&nbsp;&nbsp;';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

}
