<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
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
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if ( ! $this->hasErrors() )
        {
            $user = $this->getAnyUser();

            if ( $user )
            {
                $status = $user->status;

                if ( $status === User::STATUS_BANNED ) {
                    $user = null;
                    Yii::$app->session->setFlash('error', 'Your account has been banned!');
                    $this->addError('*', 'Your account has been banned!');
                }

                if ( $status === User::STATUS_DELETED ) {
                    $user = null;
                    Yii::$app->session->setFlash('error', 'Your account has been disabled!');
                    $this->addError('*', 'Your account has been disabled!');
                }

                if ( $status === User::STATUS_INACTIVE ) {
                    $user = null;
                    Yii::$app->session->setFlash('error', 'Your account has not been activated!');
                    $this->addError('*', 'Your account has not been activated!');
                }

                if ( $status === User::STATUS_ACTIVE ) {
                    if ( ! $user->validatePassword($this->password) ) {
                        $this->addError($attribute, 'Incorrect username or password.');
                    }
                }

            } else {

                $this->addError($attribute, 'Incorrect username or password.');

            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ( $this->validate() ) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        $this->password = null;

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ( $this->_user === null ) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Finds any user by username, including non-active, banned, etc.
     *
     * This is used so we can display messages, ex: "Your account has been banned"
     *
     * @return User|null
     */
    protected function getAnyUser()
    {
        if ( $this->_user === null ) {
            $this->_user = User::findAnyByUsername($this->username);
        }

        return $this->_user;
    }
}
