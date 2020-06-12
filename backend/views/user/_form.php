<?php

/* @var $this common\components\View */
/* @var $model backend\models\CreateUserModel */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

use common\components\Helper;
use common\models\User;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'sponsor_id')->dropDownList(
            $model->sponsorDropdown(),
            ['prompt' => ' - Choose A Sponsor - ']
        ) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => (!$model->isNewRecord && !Yii::$app->user->isSuperOrHigher())]) ?>

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

            <?= $form->field($model->profile, 'zip')->widget(MaskedInput::className(), [
                'mask' => '99999',
            ]) ?>

            <?= $form->field($model->profile, 'country')->dropDownList(
                Helper::getCountriesDropdown(),
                ['prompt'=>' - Choose A Country - ']
            ) ?>

        <?php } ?>

        <?= $form->field($model, 'status')->dropDownList(
            User::getUserStatusConst(),
            ['prompt'=>' - User Status - ']
        ) ?>

        <?= (!$model->isNewRecord) ? Html::a('Change Password!', ['user/change-user-password', 'id' => $model->id]) . '<br /><br />' : '' ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
