<?php
namespace frontend\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use common\models\User;

/**
 * Change password form for current user only
 */
class ChangePasswordForm extends Model
{
    public $id;
    public $password;
    public $new_password;
    public $confirm_password;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = User::findIdentity($id);
        if ( ! $this->_user ) {
            throw new InvalidParamException('Unable to find user!');
        }

        $this->id = $this->_user->id;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'new_password', 'confirm_password'], 'required'],
            ['password', 'validatePassword'],
            [['password', 'new_password', 'confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);

        return $user->save();
    }

    public function validatePassword($attribute, $params)
    {
        $user = $this->_user;
        if ( ! Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash) ) {
            $this->addError($attribute, 'You password is incorrect!');
        }
    }

    public function resetForm()
    {
        $this->password = null;
        $this->new_password = null;
        $this->confirm_password = null;

        return true;
    }
}
