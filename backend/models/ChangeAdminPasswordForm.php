<?php
namespace backend\models;

use yii\base\Model;
use yii\web\NotFoundHttpException;

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
     * @var \backend\models\Admin
     */
    private $_user;

    /**
     * Creates a form model given a user id.
     *
     * @param  string $id
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function __construct($id, $config = [])
    {
        $this->_user = $this->findModel($id);

        $this->id = $this->_user->id;
        $this->username = $this->_user->username;
        $this->role = $this->_user->role;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
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
     * Finds the Admin model based on its primary key value.
     *
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Changes password.
     *
     * @param bool $validate whether to perform validation (via: `$model->save()`)
     * @return bool if password was changed.
     */
    public function changePassword($validate = true)
    {
        if ( ($validate === true) && (! $this->validate()) ) {
            return false;
        }

        $user = $this->_user;
        $user->setPassword($this->password);

        return $user->save();
    }

    /**
     * Reset the form to remove previously entered values
     *
     * This is optional, and only really used if redirecting the user back to
     * the same page after saving the model (changing the password).
     *
     * @return bool Always returns true since this isn't really error prone
     */
    public function resetForm()
    {
        $this->password = null;
        $this->confirm_password = null;

        return true;
    }
}
