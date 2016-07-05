<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class Profile extends Model {

    public $username;
    public $email;
    public $lastname;
    public $firstname;
    public $phone;
    public $address;
    public $city;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'lastname', 'firstname', 'email', 'phone', 'address', 'city'], 'filter', 'filter' => 'trim'],
            [['username', 'lastname', 'firstname', 'phone', 'address', 'city'], 'required'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Telephone number is the serial number'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Phone numbers must be between 10 and 11 numbers', 'tooLong' => 'Phone numbers must be between 10 and 11 numbers!'],
            ['phone', 'validatePhone'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'validateUsername'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'validateEmail']
        ];
    }

    public function validateUsername($attribute) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['username' => $this->username])->one();
            if (!empty($model)) {
                if ((string) $model->_id != \Yii::$app->user->id)
                    $this->addError($attribute, $this->username . ' already exists in the system.');
            }
        }
    }

    public function validateEmail($attribute) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['email' => $this->email])->one();
            if (!empty($model)) {
                if ($model->id != \Yii::$app->user->id)
                    $this->addError($attribute, $this->email . ' already exists in the system.');
            }
        }
    }

    public function validatePhone($attribute) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['phone' => $this->phone])->one();
            if (!empty($model)) {
                if ($model->id != \Yii::$app->user->id)
                    $this->addError($attribute, $this->phone . ' already exists in the system.');
                if (!empty($model->phone))
                    $this->addError($attribute, $this->phone . ' already exists in the system.');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function profile() {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(\Yii::$app->user->id);
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->address = $this->address;
        $user->city = $this->city;
        $user->updated_at = time();


        return $user->save() ? $user : null;
    }

}
