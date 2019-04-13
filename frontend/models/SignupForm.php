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
    public $sponsor_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

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

            ['sponsor_id', 'integer'],
            [['sponsor_id'], 'default', 'value' => null],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
     public function signup()
     {
         if ( ! $this->validate() ) {
             return false;
         }

         $user = new User();
         $user->username = $this->username;
         $user->email = $this->email;

         if ( isset($this->sponsor_id) ) {
             $user->sponsor_id = $this->sponsor_id;
         }

         if ( Yii::$app->params['signupValidation'] === true )
         {
             $user->status = User::STATUS_INACTIVE;
             $user->generateEmailVerificationToken();
         }

         $user->setPassword($this->password);
         $user->generateAuthKey();

         if ( $user->save() )
         {
             $profile = new UserProfile();
             $profile->user_id = $user->id;
             return $profile->save() && $this->sendEmail($user);
         }

         return false;
     }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        if ( Yii::$app->params['signupValidation'] === true )
        {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Account registration at ' . Yii::$app->name)
                ->send();
        }

        return true;
    }
}
