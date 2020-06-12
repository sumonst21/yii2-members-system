<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\User;
use common\components\Helper;

/* @var $this common\components\View */
/* @var $model common\models\User */

$this->title = 'Sponsor: ' . $model->username ?: '';

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// we don't need full blown, detailed checking, since we know it has to be their sponsor at this point...
$canSeeUsersInfo = ($model && ($model->shareDetailsPublic() || $model->shareDetailsTeam()) ) ? true : false;
?>
<div class="user-view">

    <?php if ($model) { ?>

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
                    'value' => function($model) use ($canSeeUsersInfo) {
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
                    'attribute' => 'email',
                    'format' => $canSeeUsersInfo ? 'email' : 'raw',
                    'value' => $canSeeUsersInfo ? $model->email : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>',
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
