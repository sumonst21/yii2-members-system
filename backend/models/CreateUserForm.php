<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Create User Form
 */
class CreateUserForm extends User
{
    public $username;
    public $nicename;
    public $email;
    public $password;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['status', 'required'],
            ['status', 'integer'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DELETED, User::STATUS_PENDING, User::STATUS_BANNED]],
        ];
    }

    /**
     * Create User Account
     *
     * @return User|null the saved model or null if saving fails
     */
    public function createUser()
    {
        if ($this->validate())
        {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save())
            {
                $profile = new \common\models\UserProfile;
                $profile->user_id = $user->id;

                return $profile->save() ? $user : null;
            }
        }

        return null;
    }

}
