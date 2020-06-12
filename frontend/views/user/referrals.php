<?php
use yii\helpers\Html;
use yii\helpers\Url;

use common\components\Helper;
use common\models\User;

use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this common\components\View */
/* @var $model common\models\User */
/* @var $referrals common\models\User */

$this->title = 'Referrals';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'username',
    [
        'attribute' => 'firstname',
        'format' => 'raw',
        'value' => function($model, $index, $dataColumn) {
            $canSeeUsersInfo = ($model->shareDetailsPublic() || $model->shareDetailsTeam() ) ? true : false;
            return $canSeeUsersInfo ? $model->profile->firstname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>';
        },
    ],
    [
        'attribute' => 'lastname',
        'format' => 'raw',
        'value' => function($model, $index, $dataColumn) {
            $canSeeUsersInfo = ($model->shareDetailsPublic() || $model->shareDetailsTeam() ) ? true : false;
            return $canSeeUsersInfo ? $model->profile->lastname : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>';
        },
    ],
    //'email:email',
    [
        'attribute' => 'email',
        'format' => 'raw',
        'value' => function($model, $index, $dataColumn) {
            $canSeeUsersInfo = ($model->shareDetailsPublic() || $model->shareDetailsTeam() ) ? true : false;
            return $canSeeUsersInfo ? Html::mailto($model->email) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>';
        },

    ],
    [
        'attribute' => 'phone',
        'format' => 'raw',
        'value' => function($model, $index, $dataColumn) {
            $canSeeUsersInfo = ($model->shareDetailsPublic() || $model->shareDetailsTeam() ) ? true : false;
            return $canSeeUsersInfo ? Helper::tel($model->profile->phone) : '<span style="color:rgb(124, 124, 126)"><em>hidden</em></span>';
        },

    ],
    [
        'attribute' => 'status',
        'label' => 'Status',
        'filter' => User::getUserStatusConst(),
        'format' => 'raw',
        'value' => function($model, $index, $dataColumn) {
                        return '<span style="color: ' . User::statusToColor($model->userStatus) . '">' . $model->userStatus . '</span>';
                    }
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Join Date',
        'format' => 'datetime',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template'=>'{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['referral', 'username' => $model->username], ['title' => 'View']);
                        },
        ],

    ]
];
?>
<div class="user-referrals">

    <?= ExportMenu::widget([
        'dataProvider' => $referrals,
        'columns' => $gridColumns,
        'columnSelectorOptions'=>[
            'label' => 'Cols...',
        ],
        'hiddenColumns'=>[0,6],     // #, hidden from column selector
        'disabledColumns'=>[],      // # disabled on column selector
        'noExportColumns'=>[0,6],   // hidden from both export and column selector
        'fontAwesome' => true,
        'dropdownOptions' => [
            'label' => 'Export All',
            'class' => 'btn btn-default'
        ]
    ]); ?>

    <hr />

    <?= GridView::widget([
        'dataProvider' => $referrals,
        'columns' => $gridColumns,
    ]); ?>

</div>
