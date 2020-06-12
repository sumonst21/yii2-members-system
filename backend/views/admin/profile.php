<?php

/* @var $this common\components\View */
/* @var $model backend\models\Admin */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Profile: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'firstname',
            'lastname',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'adminRole',
            'adminStatus',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this admin?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

</div>
