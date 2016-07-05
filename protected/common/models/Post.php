<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Review;

/**
 * Blog Category model
 *
 * @property string $name
 * @property string $sectors
 */
class Post extends ActiveRecord {

    const STATUS_PUBLISH = 'publish';
    const STATUS_PRIVATE = 'private';

    public static function collectionName() {
        return 'posts';
    }

    public function rules() {
        return [
        ];
    }

    public function attributes() {
        return [
            '_id',
            'category_id',
            'cats',
            'user_id',
            'title',
            'slug',
            'type',
            'keywords',
            'description',
            'content',
            'rating',
            'status',
            'publish',
            'price',
            'unit',
            'images',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'title' => 'Title',
            'category_id' => 'Categoies',
            'content' => 'Content',
            'user_id' => 'Author'
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

    public function getIndent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['_id' => 'category_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'user_id']);
    }

    public function getReview() {
        $review = Review::find()->where(['user_id' => \Yii::$app->user->id, 'post_id' => $this->id])->one();
        return $review;
    }

    public function getCountrating() {
        $count_5 = Review::find()->where(['post_id' => $this->id, 'star' => '5'])->count();
        $count_4 = Review::find()->where(['post_id' => $this->id, 'star' => '4'])->count();
        $count_3 = Review::find()->where(['post_id' => $this->id, 'star' => '3'])->count();
        $count_2 = Review::find()->where(['post_id' => $this->id, 'star' => '2'])->count();
        $count_1 = Review::find()->where(['post_id' => $this->id, 'star' => '1'])->count();
        if (($count_1 + $count_2 + $count_4 + $count_3 + $count_5) > 0) {
            $total = ($count_1 + $count_2 + $count_4 + $count_3 + $count_5) / (($count_5 * 5) + ($count_4 * 4) + ($count_3 * 3) + ($count_2 * 2) + ($count_1 * 1));
            return round($total, 1);
        } else
            return 0;
    }

}
