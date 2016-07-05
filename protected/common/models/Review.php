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
class Review extends ActiveRecord {

    public static function collectionName() {
        return 'reviews';
    }

    public function rules() {
        return [
            [['content', 'user_id', 'post_id', 'star'], 'string'],
            [['star'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'content',
            'user_id',
            'post_id',
            'star',
            'created_at',
            'updated_at'
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

    public function getId() {
        return (string) $this->_id;
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'user_id']);
    }

}
