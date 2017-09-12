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

        <?= $form->field($user, 'username')->textInput(['maxlength' => true, 'readonly' => !$user->isNewRecord]) ?>

        <?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

        <?= ($user->isNewRecord) ? $form->field($user, 'password')->passwordInput() : '' ?>

        <?= $form->field($user, 'status')->dropDownList(
            $user->getUserStatusDropdown(),
            ['prompt'=>' - User Status - ']
        ) ?>

        <?= (!$user->isNewRecord) ? Html::a('Change Password!', ['user/change-user-password', 'id' => $user->id]) . '<br /><br />' : '' ?>

        <div class="form-group">
            <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
