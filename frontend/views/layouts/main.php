<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

frontend\assets\AdminLteAsset::register($this);               // includes frontend/assets/AppAsset

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$this->addBodyClass(['hold-transition', 'sidebar-mini', \frontend\assets\AdminLteAsset::skinClass()]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
</head>
<body class="<?= $this->getBodyClasses() ?>">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'partials/_header.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <?= $this->render(
        'partials/_left.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <?= $this->render(
        'partials/_content.php',
        ['content' => $content,
        'directoryAsset' => $directoryAsset]
    ) ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
