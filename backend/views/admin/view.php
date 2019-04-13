<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Admin: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
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
            'adminRole',
            'adminStatus',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <p>
        <?= ( Yii::$app->user->isRoleGreaterThan($model->role) || Yii::$app->user->isOwnModel($model->id) ) ? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
        <?= Yii::$app->user->isRoleGreaterThan($model->role) ? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this admin?',
                'method' => 'post',
            ],
        ]) : '' ?>
    </p>

</div>
