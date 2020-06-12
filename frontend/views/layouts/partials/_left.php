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

                    [
                        'label' => 'User',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Profile', 'icon' => 'address-card-o', 'url' => ['/user/index']],
                            ['label' => 'Settings', 'icon' => 'dashboard', 'url' => ['/user/settings']],
                        ],
                    ],
                    [
                        'label' => 'Network',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Sponsor', 'icon' => 'arrow-up', 'url' => ['/user/sponsor'], 'visible' => isset(Yii::$app->user->sponsor)],
                            ['label' => 'Referrals', 'icon' => 'sitemap', 'url' => ['/user/referrals']],
                        ],
                    ],
                    
                    /*
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    */
                ],
            ]
        ) ?>

    </section>

</aside>
