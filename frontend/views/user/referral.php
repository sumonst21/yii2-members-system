<?php

use yii\widgets\DetailView;
use yii\Helpers\Html;

use common\components\Helper;
use common\models\User;

/* @var $this common\components\View */
/* @var $model common\models\User */

$this->title = 'Referral: ' . $model->username;

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['referrals']];
$this->params['breadcrumbs'][] = $model->username;

// we don't need full blown, detailed checking, since we know it has to be their referral at this point...
$canSeeUsersInfo = ($model && ($model->shareDetailsPublic() || $model->shareDetailsTeam()) ) ? true : false;
?>
<div class="user-view">

    <?php if ( ! $canSeeUsersInfo ) { ?>
        <p>This user's info is private!</p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'attribute' => 'email',
                'format' => $canSeeUsersInfo ? 'email' : 'raw',
                'value' => $canSeeUsersInfo ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'firstname',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->firstname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'lastname',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->lastname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? Helper::tel($model->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'skype',
                'label' => 'Skype',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? Helper::skype($model->profile->skype) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.city',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->city : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.state',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->state : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.zip',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->zip : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.country',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->country : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
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
