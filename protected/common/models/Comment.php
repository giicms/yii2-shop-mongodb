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
class Comment extends ActiveRecord {

    public static function collectionName() {
        return 'comments';
    }

    public function rules() {
        return [
            [['comment'], 'required'],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'post_id',
            'comment',
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

}
