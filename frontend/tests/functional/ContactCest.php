<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use frontend\models\LoginForm;
use common\fixtures\User as UserFixture;
use common\fixtures\UserProfile as UserProfileFixture;

/* @var $scenario \Codeception\Scenario */

class ContactCest
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

    public function checkContact(FunctionalTester $I)
    {
        $I->amOnRoute('site/contact');

        // Requires login to access
        $I->dontSee('Contact', 'h1');
        $I->see('Member Login', 'h1');
        $I->seeLink('Forgot password');

        $user = \common\models\User::findByUsername('testuser1');
        $I->amLoggedInAs($user);

        $I->amOnRoute('site/contact');
        $I->see('Contact', 'h1');
    }

    public function checkContactSubmitNoData(FunctionalTester $I)
    {
        $user = \common\models\User::findByUsername('testuser1');
        $I->amLoggedInAs($user);

        $I->amOnRoute('site/contact');

        $I->submitForm('#contact-form', []);
        $I->see('Contact', 'h1');
        $I->seeValidationError('Name cannot be blank');
        $I->seeValidationError('Email cannot be blank');
        $I->seeValidationError('Subject cannot be blank');
        $I->seeValidationError('Body cannot be blank');
        $I->seeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitNotCorrectEmail(FunctionalTester $I)
    {
        $user = \common\models\User::findByUsername('testuser1');
        $I->amLoggedInAs($user);

        $I->amOnRoute('site/contact');

        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    public function checkContactSubmitCorrectData(FunctionalTester $I)
    {
        $user = \common\models\User::findByUsername('testuser1');
        $I->amLoggedInAs($user);

        $I->amOnRoute('site/contact');

        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
