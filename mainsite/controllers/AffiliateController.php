<?php
namespace mainsite\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use common\models\User;

class AffiliateController extends Controller
{
    /**
     * Acts as a redirect link to set the cookie.
     *
     * **NOTE:** If the affiliate is not active, it will redirect to the configured
     * redirect URL (or lp if passed) without setting a cookie. This ensures old
     * affiliate links still work, even if they don't give that person credit.
     *
     * **NOTE:** There is not an 'index' view for this action!
     */
    public function actionIndex($username, $lp = null)
    {
        $affiliate = User::findByUsername($username);

        if ( $affiliate ) {
            Yii::$app->affiliate->setCookie($affiliate->username);  // not available until next request
        }

        if ( $lp ) {
            return $this->redirect(["lp/{$lp}"]);
        }

        return $this->redirect(Yii::$app->affiliate->redirectUrl);
    }

    public function actionProfile($username)
    {
        $model = User::findByUsername($username);

        if ( ! $model ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $canSeeUsersInfo = $model->shareDetailsPublic();

        if ( ! Yii::$app->user->isGuest ) {
            $canSeeUsersInfo = $model->canSeeUsersInfo(Yii::$app->user->id);
        }

        return $this->render('profile', [
            'user' => $model,
            'canSeeUsersInfo' => $canSeeUsersInfo,
        ]);
    }

}
