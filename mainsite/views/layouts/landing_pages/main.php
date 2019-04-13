<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

/**
 * This is the default layout file for landing pages. Notice, there is NO BODY
 * structure or included scripts in the header. You will need to register any
 * needed scripts from inside the view. The view should be the full HTML of
 * what you want between the BODY tags, with the exception of your registered
 * scripts that are hooked to the HEAD, BODY (begin body), or FOOTER (end body).
 */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
