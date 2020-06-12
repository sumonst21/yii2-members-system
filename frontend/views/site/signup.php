<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this common\components\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->addBodyClass('register-page');

$fieldOptionsUsername = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptionsEmail = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptionsPassword = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">

    <div class="login-logo">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= Alert::widget() ?>

    <div class="login-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?php if (isset($sponsor) && ! empty($sponsor->username)) { ?>

                <?= $form->field($model, 'sponsor')->label(false)->hiddenInput(['value' => $sponsor->username]) ?>

                <div class="form-group row field-signupform-sponsor">
                    <label for="staticSponsor" class="col-sm-2 col-form-label">Sponsor</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticSponsor" value="<?= $sponsor->username ?>" />
                    </div>
                </div>

            <?php } ?>

            <?= $form->field($model, 'username', $fieldOptionsUsername)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('username'), 'required' => true]) ?>

            <?= $form->field($model, 'email', $fieldOptionsEmail)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('email'), 'required' => true]) ?>

            <?= $form->field($model, 'password', $fieldOptionsPassword)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'required' => true]) ?>

            <?= $form->field($model, 'confirmPassword', $fieldOptionsPassword)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('confirmPassword'), 'required' => true]) ?>

            <div class="row">

                <div class="col-xs-8">
                    <?= $form->field($model, 'terms')->label('I agree to the ' . Html::a('terms', '#terms'))->checkbox(['checked' => false, 'required' => true]) ?>
                </div>

                <div class="col-xs-4">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']) ?>
                </div>

            </div>

        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat">
                <i class="fa fa-facebook"></i> Sign up using Facebook
            </a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat">
                <i class="fa fa-google-plus"></i> Sign up using Google+
            </a>
        </div>

        <?= Html::a('I already have a membership', ['site/login']) ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
