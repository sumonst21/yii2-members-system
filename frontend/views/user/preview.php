<?php

/* @var $this common\components\View */
/* @var $model common\models\User */
/* @var $profile common\models\UserProfile */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

$title = ($type === 'team') ? 'Preview Team: ' : 'Preview Public: ';

$this->title = $title . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Preview: ' . $model->username;
?>
<div class="preview-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'sponsor_id',
                'label' => 'Sponsor',
                'format' => 'raw',
                'value' => isset($model->sponsor_id) ? Html::a($model->sponsor->username, ['/user/view', 'username' => $model->sponsor->username]) : null,
            ],
            'username',
            [
                'attribute' => 'profile.firstname',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->firstname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.lastname',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->lastname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'email',
                'format' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? 'email' : 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? Helper::tel($model->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.skype',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? Helper::skype($model->profile->skype) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.city',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->city : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.state',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->state : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.zip',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->zip : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'profile.country',
                'format' => 'raw',
                'value' => ( ($type === 'public') && $model->shareDetailsPublic() || ($type === 'team') && $model->shareDetailsTeam() ) ? $model->profile->country : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
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
