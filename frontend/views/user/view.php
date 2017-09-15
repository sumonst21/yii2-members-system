<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $profile common\models\UserProfile */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

$this->title = 'View User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
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
            'username',
            [
                'attribute' => 'email',
                'format' => 'email',
                'value' => $model->canViewProfile() ? $model->email : null,
            ],
            [
                'attribute' => 'profile.phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => $model->canViewProfile() ? Helper::tel($model->profile->phone) : null,
            ],
            [
                'attribute' => 'profile.skype',
                'format' => 'raw',
                'value' => $model->canViewProfile() ? Helper::skype($model->profile->skype) : null,
            ],
            [
                'attribute' => 'profile.firstname',
                'format' => 'text',
                'value' => $model->canViewProfile() ? $model->profile->firstname : null,
            ],
            [
                'attribute' => 'profile.lastname',
                'format' => 'text',
                'value' => $model->canViewProfile() ? $model->profile->lastname : null,
            ],
            [
                'attribute' => 'profile.address1',
                'value' => $model->canViewProfile() ? $model->profile->address1 : null,
            ],
            [
                'attribute' => 'profile.address2',
                'value' => $model->canViewProfile() ? $model->profile->address2 : null,
            ],
            [
                'attribute' => 'profile.city',
                'value' => $model->canViewProfile() ? $model->profile->city : null,
            ],
            [
                'attribute' => 'profile.state',
                'value' => $model->canViewProfile() ? $model->profile->state : null,
            ],
            [
                'attribute' => 'profile.zip',
                'value' => $model->canViewProfile() ? $model->profile->zip : null,
            ],
            [
                'attribute' => 'profile.country',
                'value' => $model->canViewProfile() ? $model->profile->country : null,
            ],

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
        <?php if ( Yii::$app->user->id === $model->id ) { ?>
            <?= Html::a('Update', 'update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete Account', 'delete-account', ['class' => 'btn btn-danger']) ?>
        <?php } ?>
    </p>

</div>
