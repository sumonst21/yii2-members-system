<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use backend\models\Admin;

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

        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => YII_DEBUG],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'visible' => YII_DEBUG],
                    [
                        'label' => 'Admins',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Overview', 'icon' => 'file-code-o', 'url' => ['/admin/index']],
                            ['label' => 'Create', 'icon' => 'file-code-o', 'url' => ['/admin/create']],
                        ],
                    ],
                    [
                        'label' => 'Users',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Overview', 'icon' => 'file-code-o', 'url' => ['/user/index']],
                            ['label' => 'Create', 'icon' => 'file-code-o', 'url' => ['/user/create']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
