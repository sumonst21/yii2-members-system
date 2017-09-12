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
            [
                'attribute' => 'sponsor_id',
                'label' => 'Sponsor',
                'format' => 'raw',
                'value' => isset($model->sponsor_id) ? Html::a($model->sponsor->username, ['/user/view', 'id' => $model->sponsor_id]) : null,
            ],
            'username',
            'email:email',
            'profile.firstname',
            'profile.lastname',
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => isset($user->profile->phone) ? \common\components\Helper::tel($user->profile->phone) : null,
            ],
            'profile.skype',
            'userStatus',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
