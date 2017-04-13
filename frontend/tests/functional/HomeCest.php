<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;
use common\fixtures\UserProfile as UserProfileFixture;

class HomeCest
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

    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');

        // should not be logged in
        $I->dontSee('Member Dashboard!', 'h1');

        // should have been redirected to login page
        $I->seeInCurrentUrl('/site/login');
        $I->see('Member Login', 'h1');
        $I->seeLink('Forgot password');
    }
}
