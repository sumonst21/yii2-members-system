<?php
namespace common\components;

use yii\web\View as WebView;

class View extends WebView
{
    public $pageTitle = null;

    public $showHeaderNotifications = true;

    public $showHeaderMessages = true;

    public $showHeaderTasks = true;

    public $showHeaderControlSidebar = true;

    public $bodyClasses = [];

    public $signupRoute = 'site/signup';

    public $signupLinkAffiliate = null;

    public function addBodyClass($class)
    {
        if ( ! is_array($class) ) {
            $class = [$class];
        }

        foreach ($class as $c) {
            $this->bodyClasses[] = trim($c);
        }
    }

    public function getBodyClasses()
    {
        return implode(' ', $this->bodyClasses);
    }

    public function hasSignupLinkAffiliate()
    {
        return ( isset($this->signupLinkAffiliate) && ! empty($this->signupLinkAffiliate) ) ? true : false;
    }

    public function getSignupLink()
    {
        $link = [$this->signupRoute];

        if ( $this->hasSignupLinkAffiliate() ) {
            $link = array_merge($link, ['aff' => $this->signupLinkAffiliate]);
        }

        return $link;
    }
}
