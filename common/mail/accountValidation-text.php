<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$validationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-account', 'token' => $user->validation_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to activate your account:

<?= $validationLink ?>
