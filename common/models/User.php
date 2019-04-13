<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

use common\models\UserProfile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const STATUS_BANNED = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            ['sponsor_id', 'integer'],
            ['sponsor_id', 'default', 'value' => null],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
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
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds any user by username, even soft-deleted, inactive, and banned!
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
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
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
     * @return bool if password provided is valid for current user
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

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    // ----- Added -----

    /**
     * Find an identity by ID and does not matter what their status is
     */
    public static function findAnyIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Get a user's related profile
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Helper function to map User Status constants to name
     */
    public static function getUserStatusConst($key = null)
    {
        if ( $key !== null ) {
            $array = self::getUserStatusConst();
            return $array[$key];
        }

        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_BANNED => 'Banned'
        ];
    }

    /**
     * Get User Status for DetailView
     */
    public function getUserStatus() {
        return self::getUserStatusConst($this->status);
    }

    /**
     * Get User Status array for drop down menu
     */
    public function getUserStatusDropdown()
    {
        return self::getUserStatusConst();
    }

    public static function statusToColor($status)
    {
        switch (strtolower($status))
        {
            case 'active':
                return 'green';
                break;
            case 'inactive':
                return 'orange';
                break;
            case 'banned':
                return 'red';
                break;
            case 'deleted':
                return 'dark-grey';
                break;
            default:
                return 'black';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSponsor()
    {
        return $this->hasOne(User::className(), ['id' => 'sponsor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(User::className(), ['sponsor_id' => 'id']);
    }

    public function sponsorDropdown()
    {
        $sponsorList = User::find()->select(['id', 'username'])->where(['status' => self::STATUS_ACTIVE]);

        if ( ! $this->isNewRecord ) {
            $sponsorList = $sponsorList->andWhere(['!=', 'id', $this->id]);
        }

        $sponsorList = $sponsorList->all();

        return ArrayHelper::map($sponsorList, 'id', 'username');
    }

    public function shareDetailsPublic()
    {
        return ( $this->profile->share_details_public == true );
    }

    public function shareDetailsTeam()
    {
        return ( $this->profile->share_details_team == true );
    }

    public function isOnTeam()
    {
        return ( (isset(Yii::$app->user->sponsor) && Yii::$app->user->sponsor->id === $this->id) || (Yii::$app->user->id === $this->sponsor_id) );
    }
}
