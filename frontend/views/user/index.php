<?php

/* @var $this common\components\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\components\Helper;
use common\models\User;

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User Profile'];
?>
<div class="user-view">

    <div class="form-horizontal" style="width:50%;margin:0 auto;">
        <div class="form-group">
            <label class="control-label col-sm-3">Affiliate Link:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= Yii::$app->urlManagerMainsite->createAbsoluteUrl(['aff/' . Yii::$app->user->username]) ?>" readonly />
            </div>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'attribute' => 'sponsor',
                'label' => 'Sponsor',
                'format' => 'raw',
                'value' => isset($model->sponsor_id) ? Html::a($model->sponsor->username, ['/user/view', 'username' => $model->sponsor->username]) : null,
            ],
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
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model) {
                    return '<span style="color: ' . User::statusToColor($model->userStatus) . '">' . $model->userStatus . '</span>';
                }
            ],
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
            <?= Html::a('Delete Account', 'delete-account', ['class' => 'btn btn-danger']) ?><br />
            <br />
            View profile as: <?= Html::a('public', ['preview', 'type' => 'public']) ?> | <?= Html::a('team', ['preview', 'type' => 'team']) ?>
        <?php } ?>
    </p>

    <p>&nbsp;</p>

</div>
