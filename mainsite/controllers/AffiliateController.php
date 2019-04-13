<?php
namespace mainsite\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use common\models\User;

class AffiliateController extends Controller
{
    public function actionIndex($id, $lp = null)
    {
        $affiliate = User::findOne($id);

        if ( ! $affiliate ) {
            throw new BadRequestHttpException('Invalid Affiliate ID!');
        }

        Yii::$app->affiliate->setCookie($affiliate->id);  // not available until next request

        if ( $lp ) {
            return $this->redirect(["lp/{$lp}"]);
        }

        return $this->redirect(Yii::$app->affiliate->redirectUrl);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        return $this->render('view', [
            'user' => $user,
        ]);
    }

}
