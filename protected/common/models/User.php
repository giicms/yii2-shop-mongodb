<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use yii\mongodb\Query;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $avatar
 * @property string $name
 * @property string $brithday
 * @property string $cmnd
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $type_of_employment
 * @property string $company_ad
 * @property string $categoty
 * @property string $level
 * @property string $description
 * @property string $skills
 * @property string $skill_language
 * @property string $authenticated
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_NOACTIVE = 1; //tài khoản chưa kích hoạt
    const STATUS_ACTIVE = 2; //tài khoản kích hoạt
    const STATUS_COMPLETE = 3; //tài khoản kích hoạt

    /**
     * @inheritdoc
     */

    public static function collectionName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
                ]
            ]
        ];
    }

    public function attributes() {
        return [
            '_id',
            'parent_id',
            'password_hash',
            'password_reset_token',
            'email',
            'auth_key',
            'firstname',
            'lastname',
            'username',
            'phone',
            'address',
            'city',
            'status',
            'role',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_NOACTIVE],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
//        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::find()
                        ->where([
                            'email' => $username
                        ])
                        ->orWhere([ 'phone' => $username])
                        ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return (string) $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public static function getAuthkeyUser($email) {
        $model = User::find()->where(['email' => $email])->one();
        if (!empty($model)) {
            return $model->auth_key;
        } else {
            return Yii::$app->security->generateRandomString();
        }
    }

}
