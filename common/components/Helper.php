<?php
namespace common\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Helper
{
    public static function tel($text, $phone = null, $options = [])
    {
        $phone = ($phone === null) ? $text : $phone;
        $phone = mb_convert_kana($phone, 'a', 'UTF-8');
        $phone = preg_replace('~[^+0-9]+~', '', $phone);
        $options['href'] = 'tel:' . $phone;
        return Html::tag('a', $text, $options);
    }

    public static function flashStatusClass($key)
    {
        if ( ! isset($key) || empty($key) ) {
            return 'warning';
        }

        $match = [
            'success' => 'success',
            'error' => 'error',
            'warning' => 'warning',
            'info' => 'info'
        ];

        return isset($match[$key]) ? $match[$key] : $match['warning'];
    }

    public static function flashStatusIcon($key)
    {
        if ( ! isset($key) || empty($key) ) {
            return 'warning';
        }

        $match = [
            'success' => 'check',
            'error' => 'ban',
            'info' => 'info',
            'warning' => 'warning',
        ];

        return isset($match[$key]) ? $match[$key] : $match['warning'];
    }

    /*
     * @todo Add support for config to control dismissible, delay, show/hide icon, close button,
     * add to classes, etc
     */
    public static function renderFlashMessage($key, $message)
    {
        $html  = '<div class="alert alert-' . self::flashStatusClass($key) . ' alert-dismissible">';
        $html .= '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $html .= '    <i class="icon fa fa-' . self::flashStatusIcon($key) . '"></i> ' . $message;
        $html .= '</div>';

        return $html;
    }

    /*
     * @todo Add support for config to control dismissible, delay, show/hide icon, close button,
     * add to classes, etc
     */
    public static function renderFlashMessages()
    {
        foreach ( Yii::$app->session->getAllFlashes() as $key => $message) {
            echo self::renderFlashMessage($key, $message);
        }
    }

}
