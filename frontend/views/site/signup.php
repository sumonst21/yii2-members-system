<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-register">
    <div class="single-page-content">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="center-box">

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                        <?php if (isset($sponsor) && ! empty($sponsor->username)) { ?>

                            <?= $form->field($model, 'sponsor_id')->label(false)->hiddenInput(['value' => $sponsor->id]) ?>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sponsor</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static" style="padding-top: 0;"><?= $sponsor->username ?></p>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                        <?php } ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

                        <div class="row">
                            <div class="col-xs-8">
                                <p style="padding-top:8px;">Already have an account? <?= Html::a('Login', ['site/login']) ?></p>
                            </div>
                            <div class="col-xs-4">
                                <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>

    </div>
</div>
