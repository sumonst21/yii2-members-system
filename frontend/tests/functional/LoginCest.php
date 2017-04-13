<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;
use common\fixtures\UserProfile as UserProfileFixture;

class LoginCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'userProfile' => [
                'class' => UserProfileFixture::className(),
                'dataFile' => codecept_data_dir() . 'user_profile.php'
            ]
        ];
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', $this->formParams('nouser', 'wrongpass'));
        $I->seeValidationError('Incorrect username or password.');
    }

    public function checkValidLogin(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm('#login-form', $this->formParams('testuser1', '123456'));
        $I->see('Member Dashboard!', 'h1');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
