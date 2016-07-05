<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Blog Category model
 *
 * @property string $name
 * @property string $sectors
 */
class Category extends ActiveRecord {

    const STATUS_PUBLISH = 'publish';
    const STATUS_PRIVATE = 'private';

    public static function collectionName() {
        return 'categories';
    }

    public function rules() {
        return [
            [['title'], 'required'],
            [['title', 'slug', 'description', 'parent_id', 'status', 'images', 'type'], 'string'],
            ['status', 'default', 'value' => self::STATUS_PUBLISH],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'parent_id',
            'title',
            'slug',
            'description',
            'status',
            'level',
            'images',
            'type',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'parent_id' => 'Parent'
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function getSelectStatus() {
        return [
            self::STATUS_PUBLISH => 'Publish',
            self::STATUS_PRIVATE => 'Private',
        ];
    }

    public function getCategories(&$data = [], $parent = "") {
        $category = Category::find()->where(['parent_id' => $parent])->andWhere(['NOT IN', '_id', isset($this->id) ? $this->id : ""])->all();
        foreach ($category as $key => $value) {
            $data[$value->id] = $value->getIndent($value->level) . $value->title;
            unset($category[$key]);
            $value->getCategories($data, $value->id);
        }
        return $data;
    }

    public function getIndent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

    public function getCategory() {
        return $this->hasOne(BlogCategory::className(), ['_id' => 'parent']);
    }

    public function getParent() {
        return $this->hasOne(Category::className(), ['_id' => 'parent_id']);
    }

    public function getTypes() {
        return [
            'product' => 'Product',
            'blog' => 'Blog'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
