<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $lastname;
    public $firstname;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'lastname', 'firstname', 'password', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'lastname', 'firstname', 'password', 'email'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'The passwords do not match!'],
        ];
    }

  

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->created_at = $user->updated_at = time();
        $user->role = 'member';
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

}
