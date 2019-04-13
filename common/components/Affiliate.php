<?php
namespace common\components;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidParamException;
use yii\web\Cookie;

class Affiliate extends BaseObject
{
    public $cookieName = 'affiliate_cookie';
    public $cookieDuration = 30;
    public $cookieDomain = null;
    public $redirectUrl = 'index';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

   public function setCookie($affiliate_id)
   {
       if ( ! isset($affiliate_id) ) {
           throw new InvalidParamException('Can not create affiliate cookie without an id!');
       }

       $cookies = Yii::$app->response->cookies;

       $cookie = new Cookie([
           'name' => $this->cookieName,
           'value' => $affiliate_id,
           'expire' => time() + 86400 * $this->cookieDuration,
       ]);

       if ( isset($this->cookieDomain) ) {
           $cookie->domain = $this->cookieDomain;
       }

       $cookies->add($cookie);
   }

   public function removeCookie()
   {
       $cookies = Yii::$app->response->cookies;
       $cookies->remove($this->cookieName);
       unset($cookies[$this->cookieName]);
   }

   public function getCookie()
   {
       $cookies = Yii::$app->request->cookies;
       $cookie = $cookies->getValue($this->cookieName, null);
       return isset($cookie) ? $cookie : null;
   }
}
