<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use common\components\Helper;

$this->title = 'Member Login';
?>
<div class="container site-login">
    <div class="single-page-content">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= Helper::renderFlashMessages() ?>

        <div class="center-box">

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => $model->username ? false : true]) ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => $model->username ? true : false]) ?>

                        <div class="row">
                            <div class="col-xs-8">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            </div>
                            <div class="col-xs-4">
                                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="row">
                &nbsp;
            </div>

            <div class="row">
                <div class="col-sm-6 pull-left">
                    <?= Html::a('Forgot password', ['site/request-password-reset']) ?>
                </div>
                <div class="col-sm-6 pull-right text-right">
                    Don't have an account? <?= Html::a('Register', ['site/signup']) ?>
                </div>
            </div>

        </div>

    </div>
</div>
