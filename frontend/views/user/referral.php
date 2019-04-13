<?php

use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Referral: ' . $model->username;

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['referrals']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'attribute' => 'email',
                'format' => $model->shareDetailsTeam() ? 'email' : 'raw',
                'value' => $model->shareDetailsTeam() ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'firstname',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->firstname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'lastname',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->lastname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ?  ($model->profile->phone ? Helper::tel($model->profile->phone) : null) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'skype',
                'label' => 'Skype',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->skype : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.city',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->city : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.state',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->state : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.zip',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->zip : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.country',
                'format' => 'raw',
                'value' => $model->shareDetailsTeam() ? $model->profile->country : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model) {
                    return '<span style="color: ' . User::statusToColor($model->userStatus) . '">' . $model->userStatus . '</span>';
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Join Date',
                'format' => 'datetime',
                'value' => $model->created_at,
            ],
        ],
    ]) ?>

</div>
