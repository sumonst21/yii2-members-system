<?php
namespace backend\models;

use Yii;

use common\models\User;
use common\models\UserProfile;

/**
 * Create User Form
 */
class CreateUserForm extends User
{
    public $id;
    public $sponsor_id;
    public $username;
    public $email;
    public $password;
    public $status;
    public $firstname;
    public $lastname;
    public $phone;
    public $skype;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sponsor_id', 'integer'],
            ['sponsor_id', 'default', 'value' => null],

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
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DELETED, User::STATUS_INACTIVE, User::STATUS_BANNED]],

            [['firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [['firstname', 'lastname'], 'string', 'max' => 30],

            [['phone', 'skype'], 'string', 'max' => 50],

            // handle annoying update action, setting our null columns to empty string
            [['firstname', 'lastname', 'phone', 'skype'], 'default', 'value' => null],
        ];
    }

    /**
     * Create User Account
     *
     * @param bool $validate whether to perform validation (via: `$model->save()`)
     * @return User|false the saved model or false if saving fails
     */
    public function createUser($validate = true)
    {
        if ( ($validate === true) && (! $this->validate()) ) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->sponsor_id = $this->sponsor_id;

            if ( ! $user->save() ) {
                $transaction->rollBack();
                return false;
            }

            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->phone = $this->phone;
            $profile->skype = $this->skype;

            if ( ! $profile->save() ) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

            $this->id = $user->id;
            return $user;

        } catch (\Exception $e) {

            $transaction->rollBack();
            throw $e;

        } catch (\Throwable $e) {

            $transaction->rollBack();
            throw $e;

        }

        return false;
    }

}
