<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class ChangePassword extends Model {

    public $password;
    public $password_new;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['password_new', 'password_repeat', 'password'], 'required'],
            [['password', 'password_new', 'password_repeat'], 'string', 'min' => 6],
            ['password', 'validatePassword'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => 'The passwords do not match!'],
            ['password_new', 'validatePasswordNew'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = User::findByUsername(\Yii::$app->user->identity->email);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }
       public function validatePasswordNew($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->password == $this->password_new) {
                $this->addError($attribute, 'The new password must be different from the old password.');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function change() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findOne(\Yii::$app->user->id);
        $user->setPassword($this->password_new);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

}
