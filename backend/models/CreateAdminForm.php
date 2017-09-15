<?php
namespace backend\models;

use Yii;
use yii\base\Model;

use backend\models\Admin;

/**
 * Create Admin Form
 */
class CreateAdminForm extends Admin
{
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $role;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 20],

            [['firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [['firstname', 'lastname'], 'string', 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['status', 'required'],
            ['status', 'integer'],
            ['status', 'default', 'value' => Admin::STATUS_ACTIVE],
            ['status', 'in', 'range' => [Admin::STATUS_DELETED, Admin::STATUS_ACTIVE, Admin::STATUS_BANNED]],

            ['role', 'required'],
            ['role', 'integer'],
            ['role', 'default', 'value' => Admin::ROLE_ADMIN],
            ['role', 'in', 'range' => [Admin::ROLE_ROOT, Admin::ROLE_SUPER, Admin::ROLE_ADMIN]],

            // handle annoying update action, setting our null columns to empty string
            [['firstname', 'lastname'], 'default', 'value' => null],
        ];
    }

    /**
     * Creates Admin account
     *
     * @return Admin|null the saved model or null if saving fails
     */
    public function createAdmin($validate = true)
    {
        if ( ($validate === true) && !$this->validate() ) {
            return false;
        }

        $admin = new Admin();
        $admin->firstname = $this->firstname;
        $admin->lastname = $this->lastname;
        $admin->username = $this->username;
        $admin->email = $this->email;
        $admin->role = $this->role;
        $admin->status = $this->status;
        $admin->setPassword($this->password);
        $admin->generateAuthKey();

        if ($admin->save()) {
            $this->id = $admin->id;
            return $admin;
        }

        return false;
    }

}
