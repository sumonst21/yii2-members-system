<?php

/* @var $this common\components\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;

$this->title = 'View User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'sponsor_id',
                'label' => 'Sponsor',
                'format' => 'raw',
                'value' => isset($model->sponsor_id) ? Html::a($model->sponsor->username, ['/user/view', 'id' => $model->sponsor_id]) : null,
            ],
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => Helper::tel($model->profile->phone),
            ],
            [
                'attribute' => 'skype',
                'label' => 'Skype',
                'format' => 'raw',
                'value' => Helper::skype($model->profile->skype),
            ],

            'profile.firstname',
            'profile.lastname',
            'profile.address1',
            'profile.address2',
            'profile.city',
            'profile.state',
            'profile.zip',
            'profile.country',

            'userStatus',
            'created_at:datetime',
            // Fix to get correct last updated timestamp, depending on which was updated last (user or user_profile)
            [
                'label' => 'Updated At',
                'value' => ($model->profile->updated_at > $model->updated_at) ? $model->profile->updated_at : $model->updated_at,
                'format' => 'datetime',
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
