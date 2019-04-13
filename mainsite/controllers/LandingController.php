<?php
namespace mainsite\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

use common\models\User;

class LandingController extends Controller
{
    public function actionIndex($id = 1)
    {
        $view = "lp_{$id}";

        $sponsor_id = Yii::$app->affiliate->getCookie();

        if ( ! $sponsor_id ) {
            throw new BadRequestHttpException('Cookie Missing!');
        }

        $sponsor = User::find()->select('id, username, email, status')->where('id = :userid', [':userid' => $sponsor_id])->one();

        if ( ! $sponsor ) {
            throw new NotFoundHttpException("The sponsor was not found!");
        }

        $data = ['sponsor' => $sponsor];        // can hold dynamic info for the landing page

        $this->layout = '//landing_pages/main';

        return $this->render($view, [
            'data' => $data,
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
