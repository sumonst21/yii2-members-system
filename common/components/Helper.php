<?php
namespace common\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Helper
{

    public static function log($data, $filename = null, $append = true)
    {
        if ( ! isset($filename) ) {
            $filename = Yii::getAlias('@app/runtime/logs/helper.log');
        } else {
            $filename = Yii::getAlias($filename);
        }

        $before = '[' . date('m-d-Y h:i:s') . '] ';
        $after = PHP_EOL . '--------------------' . PHP_EOL . PHP_EOL;

        $requestedDir = pathinfo($filename, PATHINFO_DIRNAME);

        if ( ! is_dir($requestedDir) ) {
            FileHelper::createDirectory($requestedDir, 0755, true);
        }

        $formattedData = null;

        if ( is_string($data) ) {
            $formattedData = $data;
        } elseif ( is_array($data) || is_object($data) ) {
            $formattedData = PHP_EOL . print_r($data, true);
        } else {
            ob_start();
            var_dump($data);
            $formattedData = PHP_EOL . ob_get_clean();
        }

        $formattedData = $before . $formattedData . $after;

        $result = null;
        if ( $append ) {
            $result = file_put_contents($filename, $formattedData, LOCK_EX | FILE_APPEND);
        } else {
            $result = file_put_contents($filename, $formattedData, LOCK_EX);
        }

        return isset($result) ? $result : false;
    }

    public static function tel($text, $phone = null, $options = [])
    {
        if ( ! $text ) {
            return null;
        }

        $phone = ($phone === null) ? $text : $phone;
        $phone = mb_convert_kana($phone, 'a', 'UTF-8');
        $phone = preg_replace('~[^+0-9]+~', '', $phone);
        $options['href'] = 'tel:' . $phone;
        return Html::tag('a', $text, $options);
    }

    public static function skype($text, $skypeId = null, $options = [])
    {
        if ( ! $text ) {
            return null;
        }

        $skypeId = ($skypeId === null) ? $text : $skypeId;
        $options['href'] = 'skype:' . $skypeId . '?userinfo';
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

    public static function getCountriesDropdown()
    {
        return [
            'Common' => self::getCommonCountries(),
            'A-Z' => self::getAllCountries(),
        ];
    }

    public static function getCommonCountries()
    {
        return [
            'United States' => 'United States',
            'Australia' => 'Australia',
            'Canada' => 'Canada',
            'Germany' => 'Germany',
            'United Kingdom' => 'United Kingdom',
        ];
    }

    public static function getAllCountries()
    {
        return [
            'Afghanistan' => 'Afghanistan',
            'Albania' => 'Albania',
            'Algeria' => 'Algeria',
            'Andorra' => 'Andorra',
            'Angola' => 'Angola',
            'Antigua and Barbuda' => 'Antigua and Barbuda',
            'Argentina' => 'Argentina',
            'Armenia' => 'Armenia',
            'Australia' => 'Australia',
            'Austria' => 'Austria',
            'Azerbaijan' => 'Azerbaijan',
            'The Bahamas' => 'The Bahamas',
            'Bahrain' => 'Bahrain',
            'Bangladesh' => 'Bangladesh',
            'Barbados' => 'Barbados',
            'Belarus' => 'Belarus',
            'Belgium' => 'Belgium',
            'Belize' => 'Belize',
            'Benin' => 'Benin',
            'Bhutan' => 'Bhutan',
            'Bolivia' => 'Bolivia',
            'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
            'Botswana' => 'Botswana',
            'Brazil' => 'Brazil',
            'Brunei' => 'Brunei',
            'Bulgaria' => 'Bulgaria',
            'Burkina Faso' => 'Burkina Faso',
            'Burundi' => 'Burundi',
            'Cabo Verde' => 'Cabo Verde',
            'Cambodia' => 'Cambodia',
            'Cameroon' => 'Cameroon',
            'Canada' => 'Canada',
            'Central African Republic' => 'Central African Republic',
            'Chad' => 'Chad',
            'Chile' => 'Chile',
            'China' => 'China',
            'Colombia' => 'Colombia',
            'Comoros' => 'Comoros',
            'Democratic Republic of the Congo' => 'Democratic Republic of the Congo',
            'Republic of the Congo' => 'Republic of the Congo',
            'Costa Rica' => 'Costa Rica',
            'Côte d’Ivoire' => 'Côte d’Ivoire',
            'Croatia' => 'Croatia',
            'Cuba' => 'Cuba',
            'Cyprus' => 'Cyprus',
            'Czech Republic' => 'Czech Republic',
            'Denmark' => 'Denmark',
            'Djibouti' => 'Djibouti',
            'Dominica' => 'Dominica',
            'Dominican Republic' => 'Dominican Republic',
            'East Timor (Timor-Leste)' => 'East Timor (Timor-Leste)',
            'Ecuador' => 'Ecuador',
            'Egypt' => 'Egypt',
            'El Salvador' => 'El Salvador',
            'Equatorial Guinea' => 'Equatorial Guinea',
            'Eritrea' => 'Eritrea',
            'Estonia' => 'Estonia',
            'Eswatini' => 'Eswatini',
            'Ethiopia' => 'Ethiopia',
            'Fiji' => 'Fiji',
            'Finland' => 'Finland',
            'France' => 'France',
            'Gabon' => 'Gabon',
            'The Gambia' => 'The Gambia',
            'Georgia' => 'Georgia',
            'Germany' => 'Germany',
            'Ghana' => 'Ghana',
            'Greece' => 'Greece',
            'Grenada' => 'Grenada',
            'Guatemala' => 'Guatemala',
            'Guinea' => 'Guinea',
            'Guinea-Bissau' => 'Guinea-Bissau',
            'Guyana' => 'Guyana',
            'Haiti' => 'Haiti',
            'Honduras' => 'Honduras',
            'Hungary' => 'Hungary',
            'Iceland' => 'Iceland',
            'India' => 'India',
            'Indonesia' => 'Indonesia',
            'Iran' => 'Iran',
            'Iraq' => 'Iraq',
            'Ireland' => 'Ireland',
            'Israel' => 'Israel',
            'Italy' => 'Italy',
            'Jamaica' => 'Jamaica',
            'Japan' => 'Japan',
            'Jordan' => 'Jordan',
            'Kazakhstan' => 'Kazakhstan',
            'Kenya' => 'Kenya',
            'Kiribati' => 'Kiribati',
            'North Korea' => 'North Korea',
            'South Korea' => 'South Korea',
            'Kosovo' => 'Kosovo',
            'Kuwait' => 'Kuwait',
            'Kyrgyzstan' => 'Kyrgyzstan',
            'Laos' => 'Laos',
            'Latvia' => 'Latvia',
            'Lebanon' => 'Lebanon',
            'Lesotho' => 'Lesotho',
            'Liberia' => 'Liberia',
            'Libya' => 'Libya',
            'Liechtenstein' => 'Liechtenstein',
            'Lithuania' => 'Lithuania',
            'Luxembourg' => 'Luxembourg',
            'Madagascar' => 'Madagascar',
            'Malawi' => 'Malawi',
            'Malaysia' => 'Malaysia',
            'Maldives' => 'Maldives',
            'Mali' => 'Mali',
            'Malta' => 'Malta',
            'Marshall Islands' => 'Marshall Islands',
            'Mauritania' => 'Mauritania',
            'Mauritius' => 'Mauritius',
            'Mexico' => 'Mexico',
            'Federated States of Micronesia' => 'Federated States of Micronesia',
            'Moldova' => 'Moldova',
            'Monaco' => 'Monaco',
            'Mongolia' => 'Mongolia',
            'Montenegro' => 'Montenegro',
            'Morocco' => 'Morocco',
            'Mozambique' => 'Mozambique',
            'Myanmar (Burma)' => 'Myanmar (Burma)',
            'Namibia' => 'Namibia',
            'Nauru' => 'Nauru',
            'Nepal' => 'Nepal',
            'Netherlands' => 'Netherlands',
            'New Zealand' => 'New Zealand',
            'Nicaragua' => 'Nicaragua',
            'Niger' => 'Niger',
            'Nigeria' => 'Nigeria',
            'North Macedonia' => 'North Macedonia',
            'Norway' => 'Norway',
            'Oman' => 'Oman',
            'Pakistan' => 'Pakistan',
            'Palau' => 'Palau',
            'Panama' => 'Panama',
            'Papua New Guinea' => 'Papua New Guinea',
            'Paraguay' => 'Paraguay',
            'Peru' => 'Peru',
            'Philippines' => 'Philippines',
            'Poland' => 'Poland',
            'Portugal' => 'Portugal',
            'Qatar' => 'Qatar',
            'Romania' => 'Romania',
            'Russia' => 'Russia',
            'Rwanda' => 'Rwanda',
            'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
            'Saint Lucia' => 'Saint Lucia',
            'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
            'Samoa' => 'Samoa',
            'San Marino' => 'San Marino',
            'Sao Tome and Principe' => 'Sao Tome and Principe',
            'Saudi Arabia' => 'Saudi Arabia',
            'Senegal' => 'Senegal',
            'Serbia' => 'Serbia',
            'Seychelles' => 'Seychelles',
            'Sierra Leone' => 'Sierra Leone',
            'Singapore' => 'Singapore',
            'Slovakia' => 'Slovakia',
            'Slovenia' => 'Slovenia',
            'Solomon Islands' => 'Solomon Islands',
            'Somalia' => 'Somalia',
            'South Africa' => 'South Africa',
            'Spain' => 'Spain',
            'Sri Lanka' => 'Sri Lanka',
            'Sudan' => 'Sudan',
            'South Sudan' => 'South Sudan',
            'Suriname' => 'Suriname',
            'Sweden' => 'Sweden',
            'Switzerland' => 'Switzerland',
            'Syria' => 'Syria',
            'Taiwan' => 'Taiwan',
            'Tajikistan' => 'Tajikistan',
            'Tanzania' => 'Tanzania',
            'Thailand' => 'Thailand',
            'Togo' => 'Togo',
            'Tonga' => 'Tonga',
            'Trinidad and Tobago' => 'Trinidad and Tobago',
            'Tunisia' => 'Tunisia',
            'Turkey' => 'Turkey',
            'Turkmenistan' => 'Turkmenistan',
            'Tuvalu' => 'Tuvalu',
            'Uganda' => 'Uganda',
            'Ukraine' => 'Ukraine',
            'United Arab Emirates' => 'United Arab Emirates',
            'United Kingdom' => 'United Kingdom',
            'United States' => 'United States',
            'Uruguay' => 'Uruguay',
            'Uzbekistan' => 'Uzbekistan',
            'Vanuatu' => 'Vanuatu',
            'Vatican City' => 'Vatican City',
            'Venezuela' => 'Venezuela',
            'Vietnam' => 'Vietnam',
            'Yemen' => 'Yemen',
            'Zambia' => 'Zambia',
            'Zimbabwe' => 'Zimbabwe',
        ];
    }
}
