<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\models\UserProfile;
use frontend\components\BaseController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = \Yii::$app->user->id;

        return $this->render('index', [
            'user' => $this->findModel($id),
            'profile' => UserProfile::findOne(['user_id' => $id]),
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null)
    {
        if ( ! isset($id) ) {
            $id = \Yii::$app->user->id;
        }

        $user = User::findOne($id);
        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $profile = UserProfile::findOne(['user_id' => $id]);
        if ( ! $profile ) {
            throw new NotFoundHttpException("The profile was not found.");
        }

        return $this->render('view', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Updates current users User and Profile model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @return mixed
     */
    public function actionUpdate($id=null)
    {
        if ( isset($id) && ($id != \Yii::$app->user->id) ) {
            throw new ForbiddenHttpException('You can only update your own account!');
        }

        $id = Yii::$app->user->id;
        $user = User::findOne($id);

        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $profile = UserProfile::findOne($user->userProfile->id);
        if ( ! $profile ) {
            throw new NotFoundHttpException("The profile was not found.");
        }

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post()))
        {
            $isValid = $user->validate();
            $isValid = $profile->validate() && $isValid;

            if ( $isValid )
            {
                $user->save(false);
                $profile->save(false);
                Yii::$app->session->setFlash('success', 'Your account has been updated!');

                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'user' => $user,
            'profile' => $profile,
        ]);

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ( isset($id) && ($id != \Yii::$app->user->id) ) {
            throw new ForbiddenHttpException('You can only delete your own account!');
        }

        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;

        if ( ! $model->validate() || ! $model->save() ) {
            throw new \common\components\GenericError('Error deleting account!');
        }

        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Your account has been deleted!');

        return $this->goHome();
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

    // --- Added ---

    /**
     * Change User password.
     *
     * @param integer id
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangePassword()
    {
        $id = \Yii::$app->user->id;

        try {
            $model = new \frontend\models\ChangePasswordForm($id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Password Changed!');
        }

        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays current users profile.
     * @return mixed
     */
    public function actionProfile()
    {
        $id = \Yii::$app->user->id;
        $user = User::findOne($id);

        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        return $this->render('profile', [
            'user' => $user,
            'profile' => UserProfile::findOne(['user_id' => $id]),
        ]);
    }

    /**
     * Updates current users User and Profile model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @return mixed
     */
    public function actionSettings()
    {
        $id = \Yii::$app->user->id;

        $user = User::findOne($id);
        if ( ! $user ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $profile = UserProfile::findOne($user->userProfile->id);
        if ( ! $profile ) {
            throw new NotFoundHttpException("The profile was not found.");
        }

        if ( $profile->load(Yii::$app->request->post()) )
        {
            if ( $profile->validate() && $profile->save(false) ) {
                Yii::$app->session->setFlash('success', 'Your settings have been saved!');
            }
        }

        return $this->render('settings', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function actionDeleteAccount()
    {
        $model = User::findOne(\Yii::$app->user->id);

        if ( ! $model ) {
            throw new NotFoundHttpException("The user was not found.");
        }

        return $this->render('deleteAccount', ['model' => $model]);
    }
}
