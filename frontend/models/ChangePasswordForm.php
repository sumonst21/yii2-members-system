<?php
namespace frontend\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\web\NotFoundHttpException;

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
     * Creates a form model given a user id.
     *
     * @param integer $id the user id
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws NotFoundHttpException if the user can not be found
     */
    public function __construct($id, $config = [])
    {
        if (($this->_user = User::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->id = $this->_user->id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        $user = $this->_user;

        if ( ! Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash) ) {
            $this->addError($attribute, 'Your password is incorrect!');
        }
    }

    /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword($validate = true)
    {
        if ( ($validate === true) && !$this->validate() ) {
            return false;
        }

        $user = $this->_user;
        $user->setPassword($this->new_password);

        return $user->save();
    }

    public function resetForm()
    {
        $this->password = null;
        $this->new_password = null;
        $this->confirm_password = null;

        return true;
    }
}
