<?php

/* @var $this yii\web\View */
/* @var $model common\models\Admin */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Admin Password (' . $model->username . ')';
?>
<div class="user-changePassword">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
