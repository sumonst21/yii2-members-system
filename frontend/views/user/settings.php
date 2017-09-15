<?php

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'User Settings';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Settings'];
?>
<div class="user-settings">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'receive_emails')->checkBox(['label' => 'Receive System E-Mails?', 'selected' => $model->receive_emails]) ?>
        <p class="help-block">You will still receive system emails (change password, etc.). This opts you out of any additional marketing emails (updates, webinar, new changes, etc)</p>

        <p>&nbsp;</p>

        <?= $form->field($model, 'share_details')->checkBox(['label' => 'Share Details?', 'selected' => $model->share_details]) ?>
        <p class="help-block">Whether or not to show your profile information to other users.</p>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
