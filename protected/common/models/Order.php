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
class Order extends ActiveRecord {

    public static function collectionName() {
        return 'orders';
    }

    public function rules() {
        return [
            [['name', 'phone', 'address', 'email', 'city'], 'string'],
            [['created_at', 'updated_at', 'status', 'total'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'email',
            'phone',
            'address',
            'city',
            'products',
            'total',
            'status',
            'bank_name',
            'bank_account',
            'bank_address',
            'note',
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
