<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use dmstr\widgets\Menu;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::base() ?>/images/blank-profile-icon.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?= Html::encode(Yii::$app->user->niceName) ?></p>
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

        <?= Menu::widget([
            'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
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
            ],
        ]) ?>

    </section>

</aside>
