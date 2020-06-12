<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <?php if ( $this->showHeaderMessages === true ) { ?>
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">5</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 5 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <?= $this->render(
                                    'demo/_messages.php',
                                    ['directoryAsset' => $directoryAsset]
                                ) ?>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ( $this->showHeaderNotifications === true ) { ?>
                    <!-- Notifications: style can be found in dropdown.less-->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">5</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 5 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <?= $this->render(
                                    'demo/_notifications.php',
                                    ['directoryAsset' => $directoryAsset]
                                ) ?>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ( $this->showHeaderTasks === true ) { ?>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <?= $this->render(
                                    'demo/_tasks.php',
                                    ['directoryAsset' => $directoryAsset]
                                ) ?>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Url::to('@web/images/blank-profile-icon.png') ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Html::encode(Yii::$app->user->niceName) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Url::to('@web/images/blank-profile-icon.png') ?>" class="img-circle" alt="User Image"/>

                            <p>
                                <?= Html::encode(Yii::$app->user->niceName) ?>
                                <small>Member since <?= date('F j, Y', Yii::$app->user->createdAt) ?></small>
                            </p>
                        </li>

                        <!-- Menu Body -->
                        <!--
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Profile',
                                    ['/user/index'],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <?php if ( $this->showHeaderControlSidebar === true ) { ?>
                    <!-- Control Sidebar: style can be found in dropdown.less -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
