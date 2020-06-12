<?php
namespace mainsite\controllers;

use Yii;

use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

use common\models\User;

class LandingController extends Controller
{
    public function actionIndex($id = 1, $aff = null)
    {
        $this->layout = '//landing_pages/main';

        $view = "lp_{$id}";

        $sponsor = null;

        if ( $aff ) {
            // Sponsor forced in the URL
            $sponsor = User::findByUsername($aff);

            if ( $sponsor) {
                // sponsor passed by aff param was a valid account.
                // Handle like an affiliate link and set a cookie
                Yii::$app->affiliate->setCookie($sponsor->username);
            }
        }

        // aff param not passed, or it was for an invalid user
        // so see if we have a cookie to fall back on
        if ( ! $sponsor && ($cookie = Yii::$app->affiliate->getCookie())) {
            $sponsor = User::findByUsername($cookie);
        }

        // if we STILL don't have a sponsor, then assign one (if config allows)
        if ( ! $sponsor )
        {
            if ( Yii::$app->affiliate->randomizeOnLandingPages === true ) {
                // Pick a random user from the database to be their sponsor
                $sponsor = Yii::$app->affiliate->getRandomUser();
            } elseif ( Yii::$app->affiliate->fallbackOnLandingPages === true ) {
                if ( isset(Yii::$app->affiliate->fallbackSponsor) && ! empty(Yii::$app->affiliate->fallbackSponsor) && is_string(Yii::$app->affiliate->fallbackSponsor) ) {
                    // Find the fallback (default) sponsor
                    $sponsor = Yii::$app->affiliate->getFallbackSponsor();
                }
            }

            // if we assigned a sponsor then store the cookie (if config allows)
            if ( $sponsor && (Yii::$app->affiliate->storeCookieOnLandingPage === true) ) {
                Yii::$app->affiliate->setCookie($sponsor->username);
            }
        }

        return $this->render($view, [
            'sponsor' => $sponsor,
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found!");
        }

        return $this->render('view', [
            'user' => $user,
        ]);
    }

}
