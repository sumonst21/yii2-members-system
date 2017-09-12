<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\User;

$this->title = 'User Settings';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Settings'];
?>
<div class="user-settings">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($user); ?>

        <?= $form->errorSummary($profile); ?>

        <?= $form->field($profile, 'receive_emails')->checkBox(['label' => 'Receive System E-Mails?', 'selected' => $profile->receive_emails]) ?>
        <p class="help-block">You will still receive system emails (change password, etc.). This opts you out of any additional marketing emails (updates, webinar, new changes, etc)</p>

        <p>&nbsp;</p>

        <?= $form->field($profile, 'share_details')->checkBox(['label' => 'Share Details?', 'selected' => $profile->share_details]) ?>
        <p class="help-block">Whether or not to show your profile information to other users.</p>

        <div class="form-group">
            <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
