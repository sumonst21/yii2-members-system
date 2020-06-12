<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to('@web/images/blank-profile-icon.png') ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?= Html::encode(Yii::$app->user->niceName) ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [

                    ['label' => 'Menu', 'options' => ['class' => 'header']],

                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => YII_DEBUG && Yii::$app->user->isSuperOrHigher()],

                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'visible' => YII_DEBUG && Yii::$app->user->isSuperOrHigher()],

                    [
                        'label' => 'Admins',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Overview', 'icon' => 'address-card-o', 'url' => ['/admin/index']],
                            ['label' => 'Create', 'icon' => 'plus', 'url' => ['/admin/create'], 'visible' => Yii::$app->user->isSuperOrHigher()],
                        ],
                    ],

                    [
                        'label' => 'Users',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Overview', 'icon' => 'address-card-o', 'url' => ['/user/index']],
                            ['label' => 'Create', 'icon' => 'plus', 'url' => ['/user/create']],
                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
