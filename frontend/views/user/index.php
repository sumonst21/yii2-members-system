<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User'];
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
            'email:email',
            [
                'attribute' => 'phone',
                'label' => 'Phone',
                'format' => 'raw',
                'value' => isset($model->profile->phone) ? Helper::tel($model->profile->phone) : null,
            ],
            'profile.skype',

            'profile.firstname',
            'profile.lastname',
            'profile.address1',
            'profile.address2',
            'profile.city',
            'profile.state',
            'profile.zip',
            'profile.country',

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
            <?= Html::a('Delete Account', 'delete-account', ['class' => 'btn btn-danger']) ?><br /><br />
            <?= Html::a('View profile as others see it', ['view', 'id' => $model->id]) ?>
        <?php } ?>
    </p>

</div>
