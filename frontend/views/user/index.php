<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User'];
?>
<div class="user-view">

    <p>
        <?php
        if ( \Yii::$app->user->id === $user->id ) {
            echo Html::a('Update', 'update', ['class' => 'btn btn-primary']);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            [
                'attribute' => 'sponsor_id',
                'label' => 'Sponsor',
                'value' => $user->sponsor_id ? $user->sponsor_id->username : null,
            ],
            'username',
            'email:email',
            'userProfile.firstname',
            'userProfile.lastname',
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => isset($user->userProfile->phone) ? \common\components\Helper::tel($user->userProfile->phone) : null,
            ],
            'userProfile.skype',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => $user->userStatus,
            ],
            'created_at:datetime',
            // Fix to get correct last updated timestamp, depending on which was updated last (user or user_profile)
            [
                'label' => 'Updated At',
                'value' => ($user->userProfile->updated_at > $user->updated_at) ? $user->userProfile->updated_at : $user->updated_at,
                'format' => 'datetime',
            ],
        ],
    ]) ?>

</div>
