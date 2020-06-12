<?php

/* @var $this common\components\View */

use yii\helpers\Html;

$this->title = 'Delete Account';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>Are you sure you want to delete your account?</p>

    <?= Html::a('Delete', 'delete', [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete your account?',
            'method' => 'post',
        ],
    ]) ?>

</div>
