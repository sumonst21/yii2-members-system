<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this common\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Reset Password';
$this->addBodyClass(['site-reset-password', 'login-page']);

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= Alert::widget() ?>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please choose your new password:</p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <?= $form
            ->field($model, 'password', $fieldOptions1)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'autofocus' => true]) ?>

        <?= $form
            ->field($model, 'confirmPassword', $fieldOptions1)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('confirmPassword')]) ?>

        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Reset', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'reset-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
