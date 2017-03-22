<?php
namespace backend\models;

use backend\models\Admin;
use yii\base\Model;
use Yii;

/**
 * Create Admin Form
 */
class CreateAdminForm extends Admin
{
    public $nicename;
    public $username;
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

            ['nicename', 'filter', 'filter' => 'trim'],
            ['nicename', 'required'],
            ['nicename', 'string', 'min' => 4, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['role', 'required'],
            ['role', 'integer'],
            ['role', 'default', 'value' => Admin::ROLE_ADMIN],
            ['role', 'in', 'range' => [Admin::ROLE_ROOT, Admin::ROLE_SUPER, Admin::ROLE_ADMIN]],

            ['status', 'required'],
            ['status', 'integer'],
            ['status', 'default', 'value' => Admin::STATUS_ACTIVE],
            ['status', 'in', 'range' => [Admin::STATUS_DELETED, Admin::STATUS_ACTIVE, Admin::STATUS_BANNED]],
        ];
    }

    /**
     * Creates Admin account
     *
     * @return Admin|null the saved model or null if saving fails
     */
    public function createAdmin()
    {
        if ($this->validate()) {
            $admin = new Admin();
            $admin->nicename = $this->nicename;
            $admin->username = $this->username;
            $admin->email = $this->email;
            $admin->role = $this->role;
            $admin->status = $this->status;
            $admin->setPassword($this->password);
            $admin->generateAuthKey();
            if ($admin->save()) {
                return $admin;
            }
        }

        return null;
    }

}
