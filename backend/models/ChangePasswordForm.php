<?php
namespace backend\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

use backend\models\Admin;

/**
 * Change password form for current admin user only
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
     * @param  string                          $id
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        if (($this->_user = Admin::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
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
            [['password', 'new_password','confirm_password'], 'required'],
            [['password', 'new_password','confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
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
