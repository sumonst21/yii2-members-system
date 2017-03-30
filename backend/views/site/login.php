<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Admin Login';
?>
<div class="container site-login">
    <div class="single-page-content">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= \common\components\Helper::renderFlashMessages() ?>

        <div class="center-box">

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

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

        </div>

    </div>
</div>
