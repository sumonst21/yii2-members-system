<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 30],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED, self::STATUS_BANNED]],

            ['terms', 'boolean'],
            ['terms', 'default', 'value' => false],
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
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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

    /**
     * Generates new token for email verification
     */
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

    public function isUsersSponsor()
    {
        return ( (isset(Yii::$app->user->sponsor) && Yii::$app->user->sponsor->id === $this->id) );
    }

    /**
     * Determine if the passed user id is allowed to view this user's info.
     *
     * This checks if this model belongs to the user first. Then if they share their details
     * publicly. Then only if they share their details with their team, does it check if they
     * are within the team/network.
     *
     * You want to avoid calling `isOnTeam` any more than necessary. So that also means that
     * you should avoid calling this function any more than necessary, especially if it's
     * triggering the `isOnTeam()` method.
     */
    public function canSeeUsersInfo($userId)
    {
        $userId = (int) $userId;

        // if it's their own
        if ( $userId === $this->id ) {
            return true;
        }

        // if their settings allow public viewing.
        // do this before team (downline/upline) checking because it's less expensive
        if ( $this->shareDetailsPublic() ) {
            return true;
        }

        // if their settings allow team viewing. If not, don't bother with `isOnTeam()`.
        if ( $this->shareDetailsTeam() ) {
            // if the user is on their team (within range of levelsUp/levelsDown limits)
            if ( self::isOnTeam($userId, $this->id) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a user belongs to the team/network.
     *
     * This looks through the upline and downline, respecting the configured `levelsUp` and
     * `levelsDown` values in config. If `null`, it looks infinitely up/adown.
     *
     * **WARNING: This method can become very expensive!**
     * You should avoid calling it any more than necessary. If the user has a fairly large
     * downline, it can start to become resource intensive. Store the result in a variable
     * and don't call if multiple times over and over again on the same page.
     *
     * **TIP:**
     * You should implement caching if you really intend on using this method, or other methods
     * that rely on this one, and especially if you are allowing for more than 2 downline levels
     * and/or 4 upline levels.
     *
     * It could be simple wrapper functions for `getUplineIds()` and `getDownlineIds()` that
     * store their results as JSON with a 5 or 15 minute expiration. See the documentation
     * on those two methods for more info.
     *
     * @param int $currentUserId The current user id, or id to check
     * @param int $wantsToViewUserId The user id of the user they want to view
     * @return bool Whether or not the user's id was found in the upline/downline
     */
    public static function isOnTeam($currentUsersId, $wantsToViewUserId)
    {
        // get their upline ids first because it's less expensive
        $upline = self::getUplineIds($currentUsersId, Yii::$app->affiliate->getLevelsUp());

        if ( false !== array_search($wantsToViewUserId, $upline) ) {
            return true;
        }

        // get their downline ids. this can become expensive!
        $downline = self::getDownlineIds($currentUsersId, Yii::$app->affiliate->getLevelsDown());

        if ( false !== array_search($wantsToViewUserId, $downline) ) {
            return true;
        }

        return false;
    }

    /**
     * Get the downline user ids for a user.
     *
     * This only returns an array of user ids. It is not intended for a full graphical downline viewer
     * as it doesn't provide names, usernames, or any other details.
     *
     * **NOTE:** The `currentLevel` param is not intended for your use! This function uses
     * it to keep track of how many levels it has processed, so it knows when to stop.
     *
     * **WARNING: This method can become very expensive!**
     * You should avoid calling it any more than necessary. If the user has a fairly large
     * downline, it can start to become resource intensive.
     *
     * **TIP:**
     * You should implement caching if you really intend on using this method, or other methods
     * that rely on this one, and especially if you are allowing for more than 2 downline levels.
     *
     * It could be a simple wrapper function that stores the results of this function in a file
     * as JSON with a 5 or 15 minute expiration.
     *
     * @param int $userId The user id used to fetch their downline
     * @param int|null $levels The number of levels down to retrieve
     * @param int $currentLevel Keeps track of the current level. Internal use only!
     */
    public static function getDownlineIds($userId, $levels = null, $currentLevel = 0)
    {
        if ( $userId )
        {
            $currentLevel++;

            $array = [];

            $referrals = self::find()->select(['id'])->where(['sponsor_id' => $userId])->all();

            foreach ( $referrals as $referral)
            {
                $array[] = $referral->id;

                if ( isset($levels) && is_int($levels) ) {
                    if ( $currentLevel < $levels ) {
                        $downline = self::getDownlineIds($referral->id, $levels, $currentLevel);

                        if ( $downline ) {
                            $array = array_merge($array, $downline);
                        }
                    }
                } else {
                    $downline = self::getDownlineIds($referral->id);

                    if ( $downline ) {
                        $array = array_merge($array, $downline);
                    }

                }
            }

            return $array;
        }

        return null;
    }

    /**
     * Get the upline user ids for a user.
     *
     * This only returns an array of user ids. It is not intended for a full graphical downline viewer
     * as it doesn't provide names, usernames, or any other details.
     *
     * **TIP:**
     * You should implement caching if you really intend on using this method, or other methods
     * that rely on this one, and especially if you are allowing for more than 4 upline levels.
     *
     * It could be a simple wrapper function that stores the results of this function in a file
     * as JSON with a 5 or 15 minute expiration.
     *
     * @param int $userId The user id used to fetch their upline
     * @param int|null $levels The number of levels up to retrieve
     * @return array Returns an array (containing user ids) of the user's upline
     */
    public static function getUplineIds($userId, $levels = null)
    {
        $currentLevel = 1;

        if ( $userId )
        {
            $array = [];

            // get the first sponsor initially
            $user = self::find()->select(['sponsor_id'])->where(['id' => $userId])->one();

            if ( isset($user->sponsor_id) && ! empty($user->sponsor_id) ) {
                $array[] = $user->sponsor_id;
            }

            while ( $user !== null )
            {
                if ( isset($levels) && is_int($levels) ) {
                    if ( $currentLevel >= $levels ) {
                        $user = null;
                        break;
                    }
                }

                // $user overwrites itself during the loop
                $user = self::find()->select(['sponsor_id'])->where(['id' => $user->sponsor_id])->one();

                if ( isset($user->sponsor_id) && ! empty($user->sponsor_id) ) {
                    $array[] = $user->sponsor_id;
                }

                $currentLevel++;
            }

            return $array;
        }

        return null;
    }

}
