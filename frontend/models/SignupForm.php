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
    public $sponsor;
    public $terms;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 30],

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

            ['sponsor', 'string'],
            [['sponsor'], 'default', 'value' => null],

            ['terms', 'required'],
            ['terms', 'boolean'],
        ];
    }

    /**
     * Signs a user up.
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
         $user->terms = $this->terms;

         if ( isset($this->sponsor) )
         {
             $sponsor = User::find()->select('id, username, email, status')->where('username = :username', [':username' => $this->sponsor])->one();

             if ( isset($sponsor, $sponsor->id) ) {
                 $user->sponsor_id = $sponsor->id;
             }
         }

         if ( Yii::$app->params['signupValidation'] === true ) {
             $user->status = User::STATUS_INACTIVE;
             $user->generateEmailVerificationToken();
         } else {
             $user->status = User::STATUS_ACTIVE;
         }

         $user->setPassword($this->password);
         $user->generateAuthKey();

         if ( $user->save(false) )
         {
             $profile = new UserProfile();
             $profile->user_id = $user->id;

             return $profile->save(false) && $this->sendEmail($user);
         }

         return false;
     }

    /**
     * Sends confirmation email to user
     *
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
                ->setTo($this->email)
                ->setSubject('Account registration at ' . Yii::$app->name)
                ->send();
        }

        return true;
    }
}
