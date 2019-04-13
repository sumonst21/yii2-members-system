<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $profile common\models\UserProfile */

$this->title = 'Sponsor: ' . $model->username ?: '';

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?php if ($model) { ?>

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
                    'attribute' => 'email',
                    'format' => $model->shareDetailsTeam() ? 'email' : 'raw',
                    'value' => $model->shareDetailsTeam() ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
                ],
                [
                    'attribute' => 'phone',
                    'label' => 'Phone',
                    'format' => 'raw',
                    'value' => $model->shareDetailsTeam() ? Helper::tel($model->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
                ],
                [
                    'attribute' => 'skype',
                    'label' => 'Skype',
                    'format' => 'raw',
                    'value' => $model->shareDetailsTeam() ? $model->profile->skype : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => '<span style="color: ' . User::statusToColor($model->userStatus) . '">' . $model->userStatus . '</span>',
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Join Date',
                    'format' => 'datetime',
                    'value' => $model->created_at,
                ],

            ],
        ]) ?>

    <?php } else { ?>

        <p align="center" class="h3">Sorry, you do not have a sponsor.</p>

    <?php } ?>

</div>
