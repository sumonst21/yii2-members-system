<?php
namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;

use common\models\User;
use common\models\UserSearch;
use common\models\UserProfile;

use frontend\models\ChangePasswordForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * @param string $username The username to lookup
     * @return mixed
     */
    public function actionView($username)
    {
        $model = User::findByUsername($username);

        if ( ! $model ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        /**
         * Ideally, we don't want to call `canSeeUsersInfo()` and `isOnTeam()` on the same
         * request without caching of some kind.
         *
         * This is just showcasing how you can utilize some of the info.
         */

        $isOnTeam = User::isOnTeam(Yii::$app->user->id, $model->id);

        // Acts like a basic gate.
        // If they aren't on their team, or it's not their own, throw a 404 error
        if ( ! $isOnTeam && ($model->id !== Yii::$app->user->id) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $canSeeUsersInfo = $model->canSeeUsersInfo(Yii::$app->user->id);

        return $this->render('view', [
            'model' => $model,
            'canSeeUsersInfo' => $canSeeUsersInfo,
            'isOnTeam' => $isOnTeam,
            'isOwnPage' => (Yii::$app->user->id === $model->id) ? true : false,
        ]);
    }

    /**
     * Updates current user's User and Profile model.
     *
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ( $model->load(Yii::$app->request->post()) && $model->profile->load(Yii::$app->request->post()) )
        {
            if ( $model->save() && $model->profile->save() ) {
                Yii::$app->session->setFlash('success', 'Your account has been updated!');
                return $this->redirect(['user/index']);
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
            return $this->redirect('index');
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

    public function actionReferrals()
    {
        $query = User::find()->where(['sponsor_id' => Yii::$app->user->id])->orderBy('id', 'desc');
        $query->joinWith(['profile']);

        $referrals = new ActiveDataProvider([
            'query' => $query,
        ]);;

        $referrals->setSort([
            'attributes' => [
                'id',
                'username',
                'firstname' => [
                    'asc' => ['user_profile.firstname' => SORT_ASC],
                    'desc' => ['user_profile.firstname' => SORT_DESC],
                ],
                'lastname' => [
                    'asc' => ['user_profile.lastname' => SORT_ASC],
                    'desc' => ['user_profile.lastname' => SORT_DESC],
                ],
                'email',
                'phone' => [
                    'asc' => ['user_profile.phone' => SORT_ASC],
                    'desc' => ['user_profile.phone' => SORT_DESC],
                ],
                'status',
                'created_at'
            ]
        ]);

        return $this->render('referrals', [
            'referrals' => $referrals
        ]);
    }

    /**
     * Essentially a modified 'View' action
     */
    public function actionReferral($username)
    {
        $model = User::findByUsername($username);

        // this acts as a gate to ensure you are their sponsor
        if ( ! $model || ($model->sponsor_id !== Yii::$app->user->id) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('referral', [
            'model' => $model
        ]);
    }

    /**
     * Essentially a modified 'View' action
     */
    public function actionPreview($type)
    {
        if ( ($type !== 'team') && ($type !== 'public') ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = $this->findModel(Yii::$app->user->id);

        return $this->render('preview', [
            'model' => $model,
            'type' => $type
        ]);
    }

    /**
     * Essentially a modified 'View' action
     */
    public function actionSponsor()
    {
        $sponsor = Yii::$app->user->sponsor;

        if ( ! $sponsor ) {
            throw new NotFoundHttpException('You don\'t have a sponsor.');
        }

        return $this->render('sponsor', [
            'model' => $sponsor,
        ]);
    }
}
