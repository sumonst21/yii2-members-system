<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <?php if ($model->isNewRecord) { ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

        <?php } ?>

        <?= $form->field($model->profile, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->profile, 'lastname')->textInput(['maxlength' => true]) ?>

        <?php if ( ! $model->isNewRecord ) { ?>

            <?= $form->field($model->profile, 'phone')->widget(MaskedInput::className(), [
                'mask' => '(999) 999-9999',
            ]) ?>

            <?= $form->field($model->profile, 'skype')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'address1')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'address2')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'state')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'zip')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->profile, 'country')->textInput(['maxlength' => true]) ?>

        <?php } ?>

        <?= (!$model->isNewRecord) ? Html::a('Change Password!', ['user/change-password']) . '<br /><br />' : '' ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
