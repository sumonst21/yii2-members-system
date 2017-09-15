<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;

use common\models\User;
use common\models\UserSearch;
use common\models\UserProfile;

use frontend\components\BaseController;
use frontend\models\ChangePasswordForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Show the user profile info
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(Yii::$app->user->id),
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Updates current users User and Profile model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ( $model->load(Yii::$app->request->post()) && $model->profile->load(Yii::$app->request->post()) )
        {
            if ( $model->save() && $model->profile->save() ) {
                Yii::$app->session->setFlash('success', 'Your account has been updated!');
                return $this->goHome();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $model->status = User::STATUS_DELETED;

        if ( ! $model->save(false) ) {
            throw new HttpException(500, 'Error deleting account!');
        }

        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Your account has been deleted!');

        return $this->goHome();
    }

    /**
     * Change User password.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword())
        {
            Yii::$app->session->setFlash('success', 'Your password has been changed!');
            return $this->goHome();
        }

        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }

    /**
     * Updates current user's settings.
     * @return mixed
     */
    public function actionSettings()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ( $model->profile->load(Yii::$app->request->post()) && $model->profile->save() ) {
            Yii::$app->session->setFlash('success', 'Your settings have been saved!');
        }

        return $this->render('settings', [
            'model' => $model->profile,
        ]);
    }

    public function actionDeleteAccount()
    {
        $model = $this->findModel(Yii::$app->user->id);

        return $this->render('deleteAccount', [
            'model' => $model
        ]);
    }
}
