<?php
namespace backend\components;

use Yii;
use yii\web\User as WebUserComponent;
use backend\models\Admin;

/**
 * Extended yii\web\User
 *
 * This allows us to do "Yii::$app->user->something" by adding getters
 * like "public function getSomething()"
 *
 * So we can use variables and functions directly in "->user"
 */
class AdminComponent extends WebUserComponent
{
    /**
     * Retrieve the current admin user's username
     *
     * @return string The user's username
     */
    public function getUsername()
    {
        return Yii::$app->user->identity->username;
    }

    /**
     * Retrieve the current admin user's full name
     *
     * This will attempt to combine their first and last names. If there is a
     * first name only, it will be returned. If there isn't a first or last name,
     * then this will return `null`.
     *
     * @return string|null Returns the admin user's name or `null` on error
     */
    public function getFullName()
    {
        $fullname = null;
        $firstname = Yii::$app->user->identity->firstname;
        $lastname = Yii::$app->user->identity->lastname;

        if ( isset($firstname) && ! empty($firstname) )
        {
            $fullname = $firstname;

            if ( isset($lastname) && ! empty($lastname) ) {
                $fullname .= ' ' . $lastname;
            }
        }

        return $fullname;
    }

    /**
     * Retrieve a nicer name for the current admin user.
     *
     * This will attempt to combine their first and last names. If there is a
     * first name only, it will be returned. If there isn't a first or last name,
     * the username will be returned instead.
     *
     * @param string A nice name to address the user by
     */
    public function getNicename()
    {
        return Yii::$app->user->fullName ? Yii::$app->user->fullName : Yii::$app->user->username;
    }

    public function getCreatedAt()
    {
        return Yii::$app->user->identity->created_at;
    }
    
    /**
     * Get the current admin user's role
     *
     * @return int The value of the admin user's role
     */
    public function getRole()
    {
        return Yii::$app->user->identity->role;
    }

    /**
     * Determine if the current admin user's role is 'root'.
     * @return bool Whether or not the role is equal to 'root'
     */
    public function isRoot()
    {
        return Yii::$app->user->identity->role == Admin::ROLE_ROOT;
    }

    /**
     * Determine if the current admin user's role is 'super'.
     * @return bool Whether or not the role is equal to 'super'
     */
    public function isSuper()
    {
        return Yii::$app->user->identity->role == Admin::ROLE_SUPER;
    }

    /**
     * Determine if the current admin user's role is 'admin'.
     * @return bool Whether or not the role is equal to 'admin'
     */
    public function isAdmin()
    {
        return Yii::$app->user->identity->role == Admin::ROLE_ADMIN;
    }

    /**
     * Determine if the current admin user's role is 'root' or higher.
     * @return bool Whether or not the role is greater than or equal to 'root'
     */
    public function isRootOrHigher()
    {
        return Yii::$app->user->identity->role >= Admin::ROLE_ROOT;
    }

    /**
     * Determine if the current admin user's role is 'super' or higher.
     * @return bool Whether or not the role is greater than or equal to 'super'
     */
    public function isSuperOrHigher()
    {
        return Yii::$app->user->identity->role >= Admin::ROLE_SUPER;
    }

    /**
     * Determine if the current admin user's role is 'admin' or higher.
     * @return bool Whether or not the role is greater than or equal to 'admin'
     */
    public function isAdminOrHigher()
    {
        return Yii::$app->user->identity->role >= Admin::ROLE_ADMIN;
    }

    /**
     * Determine if the current admin user's role is greater than the role
     * in question.
     *
     * This could be useful when checking against an admin model's role.
     *
     * Example:
     * ```
     * if ( Yii::$app->user->isRoleGreaterThan($model->role) ) {
     *     // user has higher role than admin model in question
     * }
     * ```
     *
     * @param int $role The role to check the user against
     * @return bool Whether or not the role is greater than the current admin's
     */
    public function isRoleGreaterThan($role)
    {
        return Yii::$app->user->identity->role > $role;
    }

    /**
     * Determine if the ID passed is the current admin user's id
     *
     * This just is to write simpler and easier to read access checks.
     *
     * @param int $id An admin user ID to check
     * @return bool Whether or not the ID belongs to the current admin
     */
    public function isOwnModel($id)
    {
        return Yii::$app->user->id === $id;
    }
}
