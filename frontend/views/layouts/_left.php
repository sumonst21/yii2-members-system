<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::base() ?>/images/blank-profile-icon.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->niceName ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    [
                        'label' => 'User',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Profile', 'icon' => 'file-code-o', 'url' => ['/user/index']],
                            ['label' => 'Settings', 'icon' => 'dashboard', 'url' => ['/user/settings']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
