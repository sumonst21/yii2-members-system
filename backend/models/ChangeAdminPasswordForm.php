<?php
namespace backend\models;

use backend\models\Admin;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Change Admin password form
 */
class ChangeAdminPasswordForm extends Model
{
    public $id;
    public $username;
    public $password;
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

        $this->_user = Admin::findIdentity($id);
        if (!$this->_user) {
            throw new InvalidParamException('Unable to find admin!');
        }
        $this->id = $this->_user->id;
        $this->username = $this->_user->username;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','confirm_password'], 'required'],
            [['password','confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
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
        $user->setPassword($this->password);

        return $user->save(false);
    }
}
