<?php

if ( ! function_exists('env') ) {
    /**
     * Gets the value of an environment variable.
     *
     * Slightly modified version from Laravel.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     *
     * @credit https://github.com/laravel/framework/blob/7.x/src/Illuminate/Support/Env.php
     */
    function env($key, $default = null)
    {
        if ( isset($_ENV[$key] ) ) {
            $value = $_ENV[$key];
            switch (strtolower($value)) {
                case 'true':
                case '(true)':
                    return true;
                case 'false':
                case '(false)':
                    return false;
                case 'empty':
                case '(empty)':
                    return '';
                case 'null':
                case '(null)':
                    return null;
                case '':
                    return $default;
            }

            if ( preg_match('/\A([\'"])(.*)\1\z/', $value, $matches) ) {
                return $matches[2];
            }

            return $value;
        }

        return $default;
    }
}

function getUrlScheme()
{
    return (env('USE_HTTPS', true) === true) ? 'https' : 'http';
}

function getDomain($subDomain = null)
{
    $subDomain = ( is_null($subDomain) && (env('USE_WWW', false) === true) ) ? 'www' : $subDomain;
    $sub = is_string($subDomain) ? $subDomain . '.' : '';

    return getUrlScheme() . '://' . $sub . env('DOMAIN_NAME');
}

function convertDaysToSeconds($days)
{
    return (int) $days * 24 * 60 * 60;
}

function convertHoursToSeconds($hours)
{
    return (int) $hours * 60 * 60;
}

function convertMinutesToSeconds($minutes)
{
    return (int) $minutes * 60;
}
