<?php
namespace common\components;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidParamException;
use yii\db\Expression;
use yii\web\Cookie;

use common\models\User;

class Affiliate extends BaseObject
{
    public $cookieName = 'affiliate_cookie';

    /**
     * @var int The number of days for the cookie duration.
     */
    public $cookieDuration = 30;

    /**
     * @var string|null The domain for the cookie (ex: mainsite.com). Required for sub-domain use!
     */
    public $cookieDomain = null;

    /**
     * @var string The URL to to redirect to.
     */
    public $redirectUrl = ['lp/1'];

    /**
     * @var bool Whether or not to pick a random sponsor on the landing pages when one wasn't set. Overrides `fallbackSponsor` usage.
     */
    public $randomizeOnLandingPages = false;

    /**
     * @var bool Whether or not to pick a random sponsor on the signup page when one wasn't set. Overrides `fallbackSponsor` usage.
     */
    public $randomizeOnSignupPage = false;

    /**
     * @var bool Whether or not to use the `fallbackSponsor` on landing pages when one wasn't set.
     */
    public $fallbackOnLandingPages = false;

    /**
     * @var bool Whether or not to use the `fallbackSponsor` on the signup page when one wasn't set.
     */
    public $fallbackOnSignupPage = false;

    /**
     * @var string|null The username for the sponsor to use, when one wasn't set. Overrode by randomization usage.
     */
    public $fallbackSponsor = null;

    /**
     * @var bool Whether or not to store a cookie on the landing page when sponsor was assigned or randomly chosen.
     */
    public $storeCookieOnLandingPage = false;

    /**
     * @var bool Whether or not to store a cookie on the signup page when sponsor was assigned or randomly chosen.
     */
    public $storeCookieOnSignupPage = false;

    /**
     * @var int The number of levels up the user's network reaches. (Default: `null` = infinity)
     */
    public $levelsUp = null;

    /**
     * @var int The number of levels down the user's network reaches. (Default: `null` = infinity)
     */
    public $levelsDown = null;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * Set the affiliate cookie.
     *
     * @param int|string $affiliate_username The affiliate's username
     */
    public function setCookie($affiliate_username)
    {
        if ( ! isset($affiliate_username) ) {
            throw new InvalidParamException('Can not create affiliate cookie without an id or username!');
        }

        $cookies = Yii::$app->response->cookies;

        $cookie = new Cookie([
            'name' => $this->cookieName,
            'value' => $affiliate_username,
            'expire' => strtotime('+' . $this->cookieDuration . ' days')
        ]);

        if ( isset($this->cookieDomain) ) {
            $cookie->domain = $this->cookieDomain;
        }

        $cookies->add($cookie);
    }

    /**
     * Remove the affiliate cookie
     */
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

    public function getRandomUser()
    {
        return User::find()
            ->select('id, username, email, status')
            ->where(['status' => User::STATUS_ACTIVE])
            ->orderBy(new Expression('rand()'))
            ->one();
    }

    public function getFallbackSponsor()
    {
        return User::find()->select('id, username, email, status')->where('username = :username', [':username' => Yii::$app->affiliate->fallbackSponsor])->one();
    }

    public function getLevelsUp()
    {
        return $this->levelsUp;
    }

    public function getLevelsDown()
    {
        return $this->levelsDown;
    }
}
