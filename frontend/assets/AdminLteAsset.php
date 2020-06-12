<?php
namespace frontend\assets;

use Yii;
use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    public $css = [
        'css/AdminLTE.min.css',
    ];

    public $js = [
        'js/adminlte.min.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }

    /**
     * It allows you to get the name of the css class.
     * You can add the appropriate class to the body tag for dynamic change the template's appearance.
     * Note: Use this fucntion only if you override the skin through configuration.
     * Otherwise you will not get the correct css class of body.
     *
     * @return string
     */
    public static function skinClass()
    {
        /** @var \frontend\assets\AdminLteAsset $bundle */
        $bundle = Yii::$app->assetManager->getBundle('frontend\assets\AdminLteAsset');

        return $bundle->skin;
    }
}
