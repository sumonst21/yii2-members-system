<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-reset-password">
    <div class="single-page-content">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="center-box">
            <p align="center">Please choose your new password</p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

                        <div class="row">
                            <div class="col-xs-4">
                                <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary pull-right']) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
