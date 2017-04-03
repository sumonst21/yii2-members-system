<?php

/* @var $this yii\web\View */
/* @var $model backend\models\CreateAdminForm */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Admin;
?>
<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= ($model->isNewRecord) ? $form->field($model, 'password')->passwordInput() : '' ?>

        <?= $form->field($model, 'role')->dropDownList(
            $model->getAdminRoleDropdown(),
            ['prompt'=>' - Admin Role - ']
        ) ?>

        <?= $form->field($model, 'status')->dropDownList(
            $model->getAdminStatusDropdown(),
            ['prompt'=>' - Admin Status - ']
        ) ?>

        <?php
        if ( ! $model->isNewRecord )
        {
            if ($model->id === Yii::$app->user->id) {
                echo Html::a('Change Password', ['admin/change-password']);
            } else {
                echo Html::a('Change Password', ['admin/change-admin-password', 'id' => $model->id]);
            }
        }
        ?>

        <div class="row">
            &nbsp;
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
