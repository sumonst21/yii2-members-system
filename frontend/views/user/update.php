<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */

use yii\helpers\Html;

$this->title = 'Update Account';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'user' => $user,
        'profile' => $profile
    ]) ?>

</div>
