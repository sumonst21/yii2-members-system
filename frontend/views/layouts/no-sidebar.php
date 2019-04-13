<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$directoryAsset = Yii::getAlias('@web/assets/themes/adminlte');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- START GRUNT HANDLING -->
    <?= Html::cssFile(YII_DEBUG ? '@web/assets/css/stylesheet.css' : '@web/assets/css/stylesheet.min.css?v=' . filemtime(Yii::getAlias('@webroot/assets/css/stylesheet.min.css'))) ?>
    <!-- END GRUNT HANDLING -->

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="no-sidebar">

<?php $this->beginBody() ?>

    <?= $content ?>

    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- START GRUNT HANDLING -->
    <?= Html::jsFile(YII_DEBUG ? '@web/assets/js/scripts.js' : '@web/assets/js/scripts.min.js?v=' . filemtime(Yii::getAlias('@webroot/assets/js/scripts.min.js'))) ?>
    <!-- END GRUNT HANDLING -->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
