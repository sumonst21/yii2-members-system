<?php
namespace frontend\tests\acceptance;

use Yii;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnRoute('site/index');

        // should not be logged in
        $I->dontSee('Member Dashboard!', 'h1');

        // should have been redirected to login page
        $I->seeInCurrentUrl('/site/login');
        $I->see('Member Login', 'h1');
        $I->seeLink('Forgot password');

        $I->wait(1); // ensure page is fully loaded

        // submit login form
        $I->submitForm('#login-form', $this->formParams('user', '123456'));

        // check if logged in
        $I->seeInCurrentUrl('/site/index');
        $I->dontSee('Member Login', 'h1');
        $I->see('Member Dashboard!', 'h1');
    }
}
