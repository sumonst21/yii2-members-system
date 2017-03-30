<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

use backend\models\Admin;
use backend\models\AdminSearch;
use backend\components\BaseController;
use backend\models\CreateAdminForm;
use backend\models\ChangePasswordForm;
use backend\models\ChangeAdminPasswordForm;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BaseController
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
                    'delete' => ['post'],
                ],
            ],

        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
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
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \backend\models\CreateAdminForm;

        if ($model->load(Yii::$app->request->post()))
        {
            if ($admin = $model->createAdmin()) {
                return $this->redirect(['view', 'id' => $admin->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // can't delete your own account
        if ( $model->id == Yii::$app->user->id ) {
            throw new ForbiddenHttpException('You do not have permission to delete your own Admin account!');
        }

        $model->status = Admin::STATUS_DELETED;
        $model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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
     * Change current Admin user's password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangePassword()
    {
        try {
            $model = new ChangePasswordForm(Yii::$app->user->id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword())
        {
            Yii::$app->session->setFlash('success', 'Password Changed!');
            return $this->goHome();
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
     * @throws BadRequestHttpException
     */
    public function actionChangeAdminPassword($id)
    {
        try {
            $model = new ChangeAdminPasswordForm($id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword())
        {
            Yii::$app->session->setFlash('success', 'Password Changed!');
            return $this->goHome();
        }

        return $this->render('changeAdminPassword', [
            'model' => $model,
        ]);
    }

}
