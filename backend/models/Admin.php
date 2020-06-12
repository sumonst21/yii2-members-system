<?php
namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Admin model
 *
 * @property integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BANNED = 99;

    const ROLE_ROOT = 100;
    const ROLE_SUPER = 50;
    CONST ROLE_ADMIN = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This username has already been taken.'],

            [['firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [['firstname', 'lastname'], 'string', 'max' => 30],

            [['created_at', 'updated_at'], 'integer'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.'],
            ['email', 'email'],

            ['status', 'required'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_BANNED]],

            ['role', 'required'],
            ['role', 'integer'],
            ['role', 'default', 'value' => self::ROLE_ADMIN],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_SUPER, self::ROLE_ROOT]],

            // handle annoying update action, setting our null columns to empty string
            [['firstname', 'lastname'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Find an identity by ID and does not matter what their status is
     */
    public static function findAnyIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds admin by username, only active!
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds any admin by username, even soft-deleted and banned!
     *
     * @param string $username
     * @return static|null
     */
    public static function findAnyByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds admin by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function getAdminRoleConst($key = null)
    {
        if ( $key !== null )
        {
            $array = self::getAdminRoleConst();
            return $array[$key];
        }

        return [
            self::ROLE_ROOT => "Root",
            self::ROLE_SUPER => "Super Administrator",
            self::ROLE_ADMIN => "Administrator"
        ];
    }

    /**
     * Get Admin Role for DetailView
     */
    public function getAdminRole()
    {
        return self::getAdminRoleConst($this->role);
    }

    public function getAdminRoleDropdown()
    {
        $userRole = Yii::$app->user->identity->role;

        $array = self::getAdminRoleConst();

        $result = [];

        /*
        if ( $userRole === self::ROLE_ROOT ) {
            $result[self::ROLE_ROOT] = $array[self::ROLE_ROOT];
        }
        */

        foreach ( $array as $key => $val ) {
            if ( $key < $userRole ) {
                $result[$key] = $val;
            }
        }

        return $result;
    }

    /**
     * Helper function to map User Status constants to name
     */
    public static function getAdminStatusConst($key = null)
    {
        if ( $key !== null )
        {
            $array = self::getAdminStatusConst();
            return $array[$key];
        }

        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_ACTIVE  => 'Active',
            self::STATUS_BANNED  => 'Banned'
        ];
    }

    /**
     * Get Admin Status for DetailView
     */
    public function getAdminStatus()
    {
        return self::getAdminStatusConst($this->status);
    }

    /**
     * Get Admin Status array for drop down menu
     */
    public function getAdminStatusDropdown()
    {
        return self::getAdminStatusConst();
    }
}
