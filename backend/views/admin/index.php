<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\models\Admin;

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'firstname',
            'lastname',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            [
                'attribute' => 'role',
                'label' => 'Role',
                'filter' => Admin::getAdminRoleConst(),
                'value' => function($model, $index, $dataColumn) {
                                return $model->adminRole;
                            }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'filter' => Admin::getAdminStatusConst(),
                'value' => function($model, $index, $dataColumn) {
                                return $model->adminStatus;
                            }
            ],
            'created_at:datetime',
            // 'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',

                'buttons' => [
                    'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'Update']);
                                },
                    'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Are you sure to delete this admin?', 'data-method' => 'post']);
                                },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <p>
        <?= Html::a('Create Admin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
