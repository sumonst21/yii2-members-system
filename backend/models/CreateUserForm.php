<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Create User Form
 */
class CreateUserForm extends User
{
    public $username;
    public $firstname;
    public $lastname;
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

            [['firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [['firstname', 'lastname'], 'string', 'max' => 30],

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

            // handle annoying update action, setting our null columns to empty string
            [['firstname', 'lastname'], 'default', 'value' => null],
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
                $profile->firstname = $this->firstname;
                $profile->lastname = $this->lastname;

                return $profile->save() ? $user : null;
            }
        }

        return null;
    }

}
