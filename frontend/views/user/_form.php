<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($user); ?>

    <?= $form->errorSummary($profile); ?>

    <?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '(999) 999-9999',
    ]) ?>

    <?= $form->field($profile, 'skype')->textInput(['maxlength' => true]) ?>

    <p><?= ( ! $user->isNewRecord) ? Html::a('Change Password!', ['user/change-password']) . '</p><p>&nbsp;</p>' : '' ?></p>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Delete Account', 'delete-account', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
