<?php
return [
    'class' => 'common\components\Affiliate',
    'cookieName' => env('AFF_COOKIE_NAME', 'affiliate_cookie'),
    'cookieDuration' => env('AFF_COOKIE_DURATION', 90),     // days
    'cookieDomain' => env('DOMAIN_NAME'),

    // Where aff links redirect to. Can be URL manager route (ie: `['site/index']`)
    // or a full URL as a string (ie: `https://google.com`)
    //'redirectUrl' => ['site/index'],          // default is `[lp/1]`

    //'levelsUp' => 1,                          // default: null = infinity
    //'levelsDown' => 3,                        // default: null = infinity

    // optional params, if you want to force users to signup under others
    'randomizeOnLandingPages' => false,         // overrides `fallbackOnLandingPages`
    'randomizeOnSignupPage' => false,           // overrides `fallbackOnSignupPage`
    //'fallbackSponsor' => null,                // string, the username to fallback to (when none set)
    //'fallbackOnLandingPages' => false,        // whether to use `fallbackSponsor` on landing pages
    //'fallbackOnSignupPage' => false,          // whether to use `fallbackSponsor` on signup page

    //'storeCookieOnLandingPage' => false,      // stores a cookie if sponsor was assigned or randomly chosen
    //'storeCookieOnSignupPage' => false,       // stores a cookie if sponsor was assigned or randomly chosen
];
