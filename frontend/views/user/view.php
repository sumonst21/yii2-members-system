<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

$this->title = 'View User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $user->username;
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
            'username',
            'email:email',
            'userProfile.firstname',
            'userProfile.lastname',
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => isset($user->userProfile->phone) ? \common\components\Helper::tel($user->userProfile->phone) : '<span class="not-set">(not set)</span>',
            ],
            'userProfile.skype',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => $user->userStatus,
            ],
            [
                'attribute' => 'sponsor_id',
                'label' => 'Sponsor',
                'value' => $user->sponsor_id->username,
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
