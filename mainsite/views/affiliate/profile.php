<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

/* @var $this common\components\View */
/* @var $user common\models\User */
/* @var $profile common\models\UserProfile */
/* @var $canSeeUsersInfo */

$this->title = 'Affiliate: ' . $user->username;

// this gets set in the View so it can be used within the layout (top header nav signup link)
$this->signupLinkAffiliate = $user->username;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'username',
            [
                'attribute' => 'niceName',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $user->profile->niceName : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'email',
                'format' => $canSeeUsersInfo ? 'email' : 'raw',
                'value' => $canSeeUsersInfo ? $user->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? Helper::tel($user->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'skype',
                'label' => 'Skype',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? Helper::skype($user->profile->skype) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($user) {
                    return '<span style="color: ' . User::statusToColor($user->userStatus) . '">' . $user->userStatus . '</span>';
                },
            ],
            'created_at:datetime',
        ],
    ]) ?>

    <p align="center">
        <?= Html::a(
            'Register',
            Yii::$app->urlManagerFrontend->createAbsoluteUrl( ['site/signup', 'aff' => $user->username] ),
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
