<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change User Password (' . $model->username . ')';
?>
<div class="user-changePassword">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
