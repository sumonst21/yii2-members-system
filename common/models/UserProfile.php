<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use common\models\User;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $bio
 * @property integer $receive_emails
 * @property integer $share_details_public
 * @property integer $share_details_team
 * @property string $phone
 * @property string $skype
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
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
            // special cases
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

            // required
            [['user_id'], 'required'],

            // unique
            [['user_id'], 'unique'],

            // string max lengths in order by length
            [['zip'], 'string', 'max' => 20],
            [['firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [['firstname', 'lastname'], 'string', 'max' => 30],
            [['phone', 'skype'], 'string', 'max' => 50],
            [['address1', 'address2', 'city', 'state', 'country'], 'string', 'max' => 100],
            [['bio'], 'string'],        // text field, no limit

            // define all our integers
            [['user_id', 'receive_emails', 'share_details_public', 'share_details_team', 'created_at', 'updated_at'], 'integer'],

            // handle default boolean column values
            [['receive_emails', 'share_details_team'], 'default', 'value' => true],     // all our true
            [['share_details_public'], 'default', 'value' => false],                    // all our false

            // handle annoying update action, setting our null columns to empty string
            [['firstname', 'lastname', 'bio', 'phone', 'skype', 'address1', 'address2', 'city', 'state', 'zip', 'country'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'bio' => 'Bio',
            'receive_emails' => 'Receive Emails',
            'share_details_public' => 'Share Details Public',
            'share_details_team' => 'Share Details Team',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'country' => 'Country',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Finds user by user id
     *
     * @param integer user id
     * @return UserProfile|null
     */
    public static function findByUserId($id)
    {
        return static::findOne(['user_id' => $id]);
    }

    public function getFullName()
    {
        $fname = $this->firstname;
        $lname = $this->lastname;

        if ( ! isset($fname) || empty($fname) ) {
            $fname = '';
        }

        if ( ! isset($lname) || empty($lname) ) {
            $lname = '';
        }

        $fullname = trim($fname . ' ' . $lname);

        return empty($fullName) ? null : $fullname;
    }

    public function getNiceName()
    {
        return $this->getFullName() ? $this->getFullName() : $this->user->username;
    }
}
