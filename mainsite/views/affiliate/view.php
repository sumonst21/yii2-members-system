<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */

$this->title = 'View Referral: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Refferrals', 'url' => ['referrals']];
$this->params['breadcrumbs'][] = $user->username;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'username',
            'userProfile.nicename',
            'email:email',
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
                'value' => ($user->userStatus == 'Active') ? 'Active' : 'Inactive',
            ],
            'created_at:datetime',
        ],
    ]) ?>
    
</div>
