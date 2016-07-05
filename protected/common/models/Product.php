<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Post;
use common\models\Category;

class Product extends Post {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'category_id', 'content', 'price'], 'required'],
            [['title', 'slug', 'content'], 'string'],
            ['status', 'default', 'value' => self::STATUS_PUBLISH],
            ['type', 'default', 'value' => 'product'],
            [['images', 'cats'], 'default']
        ];
    }

    public function getCategories(&$data = [], $parent = "") {
        $category = Category::find()->where(['parent_id' => $parent, 'type' => 'product'])->andWhere(['NOT IN', '_id', isset($this->id) ? $this->id : ""])->all();
        foreach ($category as $key => $value) {
            $data[$value->id] = $value->getIndent($value->level) . $value->title;
            unset($category[$key]);
            $value->getCategories($data, $value->id);
        }
        return $data;
    }

}
