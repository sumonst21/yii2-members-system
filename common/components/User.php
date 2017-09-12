<?php
namespace common\components;

use Yii;
use yii\web\User as UserComponent;

/**
 * Extended yii\web\User
 *
 * This allows us to do "Yii::$app->user->something" by adding getters
 * like "public function getSomething()"
 *
 * So we can use variables and functions directly in "->user"
 */
class User extends UserComponent
{
    public function getUsername()
    {
        return Yii::$app->user->identity->username;
    }

    public function getFullName()
    {
        $fullname = null;
        $firstname = Yii::$app->user->identity->profile->firstname;
        $lastname = Yii::$app->user->identity->profile->lastname;

        if ( isset($firstname) && ! empty($firstname) )
        {
            $fullname = $firstname;

            if ( isset($lastname) && ! empty($lastname) ) {
                $fullname .= ' ' . $lastname;
            }
        }

        return $fullname;
    }

    public function getNicename()
    {
        return Yii::$app->user->fullName ? Yii::$app->user->fullName : Yii::$app->user->username;
    }

}
