<?php
namespace backend\models;

use yii\base\Model;
use yii\web\NotFoundHttpException;

use backend\models\Admin;

/**
 * Change password form for current admin user only
 */
class ChangePasswordForm extends Model
{
    public $id;
    public $password;
    public $new_password;
    public $confirm_password;

    /**
     * @var \backend\models\Admin
     */
    private $_user;

    /**
     * Creates a form model given a user id.
     *
     * @param  string $id
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function __construct($id, $config = [])
    {
        $this->id = $id;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'new_password','confirm_password'], 'required'],
            [['password', 'new_password','confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
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

            if ( ! $user || ! $user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * Changes password.
     *
     * @param bool $validate whether to perform model validation (via: `$model->save(bool)`)
     * @return bool if password was changed.
     */
    public function changePassword($validate = true)
    {
        if ( $this->validate() )
        {
            $user = $this->getAnyUser();
            $user->setPassword($this->new_password);

            return $user->save($validate);
        }

        return false;
    }

    /**
     * Reset the form to remove previously entered values
     *
     * This is optional, and only really used if redirecting the user back to
     * the same page after saving the model (changing the password).
     *
     * @return bool Always returns true since this isn't really error prone
     */
    public function resetForm()
    {
        $this->password = null;
        $this->new_password = null;
        $this->confirm_password = null;

        return true;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Admin::findIdentity($this->id);
        }

        return $this->_user;
    }

    /**
     * Finds any admin by username, including non-active, banned, etc.
     *
     * This is used so admins can still change pw after banning/de-activating
     *
     * @return Admin|null
     */
    protected function getAnyUser()
    {
        if ($this->_user === null) {
            $this->_user = Admin::findAnyIdentity($this->id);
        }

        return $this->_user;
    }
}
