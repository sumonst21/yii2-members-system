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

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => (!$model->isNewRecord && !Yii::$app->user->isSuperOrHigher())]) ?>

        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= ($model->isNewRecord) ? $form->field($model, 'password')->passwordInput() : '' ?>

        <?php if ( Yii::$app->user->isRoleGreaterThan($model->role) ) { ?>

            <?= $form->field($model, 'role')->dropDownList(
                $model->getAdminRoleDropdown(),
                ['prompt'=>' - Admin Role - ']
            ) ?>

            <?= $form->field($model, 'status')->dropDownList(
                $model->getAdminStatusDropdown(),
                ['prompt'=>' - Admin Status - ']
            ) ?>

        <?php } ?>

        <?php if ( ! $model->isNewRecord ) { ?>

            <?= Html::a('Change Password', ($model->id === Yii::$app->user->id) ? ['admin/change-password'] : ['admin/change-admin-password', 'id' => $model->id]) ?>

        <?php } ?>

        <div class="row">
            &nbsp;
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
