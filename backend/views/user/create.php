<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

use common\models\User;

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="user-create">

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'sponsor_id')->dropDownList(
                $model->sponsorDropdown(),
                ['prompt' => ' - Choose A Sponsor - ']
            ) ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'email')->input('email') ?>

            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '(999) 999-9999',
            ]) ?>

            <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList(
                User::getUserStatusConst(),
                ['prompt'=>' - User Status - ']
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
