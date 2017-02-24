<?php
/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */


namespace admin\models;

use Yii;
use yii\base\Model;

/**
 * login form
 * Class FormLogin
 * @package admin\models
 */
class FormLogin extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = null;


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // account and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = \admin\models\AuthUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}