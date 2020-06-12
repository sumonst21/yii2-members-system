<?php
use yii\helpers\Html;

/*
 * This is the default landing page template.
 * If you need to add javscript/css, you should use registerJsFile and registerCssFile, which
 * will add them into the layout.
 */
$this->title = 'Landing Page 1';

$signupLink = ['site/signup'];

if ( isset($sponsor) ) {
    $signupLink['aff'] = $sponsor->username;
}
?>
<h1 style="text-align:center;">Landing Page 1</h1>

<?php if ( isset($sponsor) ) { ?>

    <p align="center">Sponsor: <?= $sponsor->username ?></p>

<?php } else { ?>

    <?php if ( Yii::$app->affiliate->randomizeOnSignupPage === true ) { ?>
        <p align="center">You do not have a sponsor! One will be randomly assigned on the signup page.</p>
    <?php } elseif ( Yii::$app->affiliate->fallbackOnSignupPage === true ) { ?>
        <p align="center">You do not have a sponsor! One will be assigned on the signup page.</p>
    <?php } else { ?>
        <p align="center">You do not have a sponsor! You may still join, but will be creating your own team without a sponsor yourself.</p>
    <?php } ?>

<?php } ?>

<p align="center">
    <?= Html::a(
        'Register',
        Yii::$app->urlManagerFrontend->createAbsoluteUrl($signupLink ),
        ['class' => 'btn btn-primary']
    ) ?>
</p>
