<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

use backend\models\Admin;
use backend\models\AdminSearch;
use backend\models\ChangeAdminPasswordForm;
use backend\models\ChangePasswordForm;
use backend\models\CreateAdminForm;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
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
                    'delete' => ['post'],
                ],
            ],

        ];
    }

    /**
     * Finds the Admin model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Admin models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws ForbiddenHttpException If the current admin is not `super` or higher
     */
    public function actionCreate()
    {
        if ( ! Yii::$app->user->isSuperOrHigher() ) {
            throw new ForbiddenHttpException('Only Super Admins and higher can create admin accounts!');
        }

        $model = new CreateAdminForm;
        $model->loadDefaultValues();

        if ( $model->load(Yii::$app->request->post()) && $model->createAdmin() )
        {
            Yii::$app->session->setFlash('success', 'The admin account has been created!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException If the current admin is not `super` or higher
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( ! Yii::$app->user->isRoleGreaterThan($model->role) && ! Yii::$app->user->isOwnModel($model->id) ) {
            throw new ForbiddenHttpException('You do not have permission to modify this admin account!');
        }

        if ( $model->load(Yii::$app->request->post()) && $model->save() )
        {
            Yii::$app->session->setFlash('success', 'The admin account has been updated!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Admin model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException If the current admin is not higher than them or is their own account
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ( ! Yii::$app->user->isRoleGreaterThan($model->role) ) {
            throw new ForbiddenHttpException('You do not have permission to delete this admin account!');
        }

        // can't delete your own account
        if ( Yii::$app->user->isOwnModel($model->id) ) {
            throw new ForbiddenHttpException('You can not delete your own account!');
        }

        $model->status = Admin::STATUS_DELETED;

        if ( $model->update() ) {
            Yii::$app->session->setFlash('success', 'The admin account has been deleted!');
        } else {
            Yii::$app->session->setFlash('error', 'Error deleting the admin account!');
        }

        return $this->redirect(['index']);
    }

    /**
     * Show current admin profile
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $model = $this->findModel(Yii::$app->user->id);

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Change current Admin user's password.
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm(Yii::$app->user->id);

        if ( $model->load(Yii::$app->request->post()) && $model->changePassword() )
        {
            Yii::$app->session->setFlash('success', 'Password Changed!');
            return $this->redirect(['profile']);
        }

        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }

    /**
     * Change Admin password.
     *
     * @param integer id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException If the current admin is not higher than them
     */
    public function actionChangeAdminPassword($id)
    {
        $model = new ChangeAdminPasswordForm($id);

        if ( ! Yii::$app->user->isRoleGreaterThan($model->role) ) {
            throw new ForbiddenHttpException('You do not have permission to change this account\'s password!');
        }

        if ( $model->load(Yii::$app->request->post()) && $model->changePassword() )
        {
            Yii::$app->session->setFlash('success', 'Password Changed!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('changeAdminPassword', [
            'model' => $model,
        ]);
    }
}
