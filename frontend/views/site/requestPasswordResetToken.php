<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-request-password-reset">
    <div class="single-page-content">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="center-box">
            <p align="center">Enter your email address below to reset your password</p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email Address') ?>

                        <div class="row">
                            <div class="col-xs-4">
                                <?= Html::submitButton(' Reset Password ', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
