<?php
namespace backend\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

use backend\models\Admin;

/**
 * Change Admin password form
 */
class ChangeAdminPasswordForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $confirm_password;
    public $role;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model for changing an administrator's password
     *
     * @param  integer                         $id
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        if (($this->_user = Admin::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->id = $this->_user->id;
        $this->username = $this->_user->username;
        $this->role = $this->_user->role;
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
    public function changePassword($validate = true)
    {
        if ( ($validate === true) && !$this->validate() ) {
            return false;
        }

        $user = $this->_user;
        $user->setPassword($this->password);

        return $user->save();
    }

    public function resetForm()
    {
        $this->password = null;
        $this->confirm_password = null;

        return true;
    }
}
