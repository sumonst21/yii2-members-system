<?php

/* @var $this common\components\View */
/* @var $model common\models\User */
/* @var $canSeeUsersInfo */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

$this->title = 'View User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">

    <!-- Just showcasing how you can utilize some of the info -->
    <?php if ( $isOwnPage ) { ?>
        <p>This is your own page!</p>
    <?php } elseif ( $isOnTeam ) { ?>
        <p>This is a team member!</p>
    <?php } ?>

    <?php if ( ! $canSeeUsersInfo ) { ?>
        <p>This profile is private!</p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute' => 'username',
                'format' => 'text',
                'value' => $model->username,
            ],

            [
                'attribute' => 'sponsor',
                'label' => 'Sponsor',
                'format' => 'raw',
                'value' => function($model) use($canSeeUsersInfo) {

                    if ( $canSeeUsersInfo ) {
                        if ( isset($model->sponsor_id) ) {
                            return Html::a($model->sponsor->username, ['/user/view', 'username' => $model->sponsor->username]);
                        }

                        return null;
                    }

                    return '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>';
                }
            ],

            [
                'attribute' => 'profile.firstname',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->firstname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],

            [
                'attribute' => 'profile.lastname',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? $model->profile->lastname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],

            [
                'attribute' => 'email',
                'format' => $canSeeUsersInfo ? 'email' : 'raw',
                'value' => $canSeeUsersInfo ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],

            [
                'attribute' => 'profile.phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => $canSeeUsersInfo ? Helper::tel($model->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
            ],

            [
                'attribute' => 'profile.skype',
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


    <p>
        <?php if ( Yii::$app->user->id === $model->id ) { ?>
            <?= Html::a('Update', 'update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete Account', 'delete-account', ['class' => 'btn btn-danger']) ?>
        <?php } ?>
    </p>

</div>
