<?php
namespace mainsite\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use mainsite\models\PasswordResetRequestForm;
use mainsite\models\ResetPasswordForm;
use mainsite\models\SignupForm;
use mainsite\models\ContactForm;
use mainsite\models\ResendVerificationEmailForm;
use mainsite\models\VerifyEmailForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // for developer use only
    // left around just so its here...
    private function createTestUserBySponsor($sponsor_id = null)
    {
        $time = time();
        $username = 'user_' . Yii::$app->security->generateRandomString(8);

        $user = new \common\models\User();
        $user->username = $username;
        $user->email = $username . '@example.com';
        $user->sponsor_id = $sponsor_id;
        $user->password_hash = Yii::$app->security->generatePasswordHash('123456');
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->created_at = $time;
        $user->updated_at = $time;

        if ( $user->save(false) ) {
            $profile = new \common\models\UserProfile();
            $profile->user_id = $user->id;

            return $profile->save(false) ? true : false;
        }

        return false;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ( $model->load(Yii::$app->request->post()) && $model->validate() )
        {
            if ( $model->sendEmail(Yii::$app->params['contactEmail']) ) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
