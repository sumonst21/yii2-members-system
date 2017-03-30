<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserProfile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirmPassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 20],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['confirmPassword', 'required'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match'],
            ['confirmPassword', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        if ( Yii::$app->params['signupValidation'] === true )
        {
            $user->status = User::STATUS_PENDING;
            $user->generateValidationToken();
        }

        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ( $user->save() )
        {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            return $profile->save() ? $user : null;
        }

        return null;
    }
}
