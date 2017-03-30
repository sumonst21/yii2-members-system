<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $profile common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= ($model->isNewRecord) ? $form->field($model, 'password')->passwordInput() : '' ?>

        <?= $form->field($model, 'status')->dropDownList(
            $model->getUserStatusDropdown(),
            ['prompt'=>' - User Status - ']
        ) ?>

        <?= (!$model->isNewRecord) ? Html::a('Change Password!', ['user/change-user-password', 'id' => $model->id]) . '<br /><br />' : '' ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
