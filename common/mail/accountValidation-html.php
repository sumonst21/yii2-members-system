<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$validationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-account', 'token' => $user->validation_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to activate your account:</p>

    <p><?= Html::a(Html::encode($validationLink), $validationLink) ?></p>
</div>
