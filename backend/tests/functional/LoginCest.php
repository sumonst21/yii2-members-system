<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\Admin as AdminFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => AdminFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
    }
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('Username', 'admin');
        $I->fillField('Password', '123456');
        $I->click('Sign in');

        $I->see('Admin Dashboard!', 'h1');
        $I->dontSee('Admin Login', 'h1');
    }
}
