<?php

namespace App\Library;

class CookieManager
{
    public const BOARD_WATCHED             = "board_watched";
    public const SAMESITE_LAX              = "Lax";
    public const SAMESITE_NONE             = "None";

    private $name;
    private $value = '';
    private $expires;     // CI_Input->set_cookie() 의 time() 을 뺀 값으로 할당할 것
    private $domain = 'ci-project.co';
    private $path = '/';
    private $prefix;
    private $secure = false;     // SSL(Secure Sockets Layer)을 사용하여 쿠키를 전송할지, 즉 HTTPS로만 쿠키를 전송할지 여부
    private $httpOnly = false;  // 클라이언트측 스크립트를 사용하여 쿠키에 액세스할 수 있는지 여부를 지정
    private $samesite = self::SAMESITE_LAX; // None || Lax  || Strict

    /**
     * constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return CookieManager
     */
    public static function Default(): CookieManager
    {
        return new CookieManager();
    }

    /**
     *
     * @return CookieManager
     */
    public static function BoardWatched(): CookieManager
    {
        return self::Default()
            ->setName(self::BOARD_WATCHED)
            ->setExpires(3600*24*365);
    }

    /**
     * @return array
     */
    public function makeOptions(): array
    {
        $options = [
            'expires' => time() + $this->expires,
            'path' => $this->path,
            'domain' => $this->domain,
            'secure' => $this->secure,
            'httponly' => $this->httpOnly,
        ];

        /**
         * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite
         * Cookies with SameSite=None must now also specify the Secure attribute (they require a secure context/HTTPS).
         */
        if ($this->secure && $this->samesite === self::SAMESITE_NONE) {
            $options['samesite'] = self::SAMESITE_NONE;
        }

        return $options;
    }

    public function makeCookie()
    {
        setcookie($this->name, $this->value, $this->makeOptions());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?: "";
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): CookieManager
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): CookieManager
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * @param int $expires
     * @return $this
     */
    public function setExpires(int $expires): CookieManager
    {
        $this->expires = $expires;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path): CookieManager
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix): CookieManager
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @param bool $secure
     * @return $this
     */
    public function setSecure(bool $secure): CookieManager
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @param bool $httpOnly
     * @return $this
     */
    public function setHttpOnly(bool $httpOnly): CookieManager
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    /**
     * @param string $samesite
     * @return $this
     */
    public function setSamesite(string $samesite): CookieManager
    {
        $this->samesite = $samesite;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function getBoardWatched(): string
    {
        if(empty($_COOKIE[self::BOARD_WATCHED])) {
            $value = uniqid('', true).bin2hex(random_bytes(5));
            self::BoardWatched()
                ->setValue($value)
                ->makeCookie();
        } else {
            $value = $_COOKIE[self::BOARD_WATCHED];
        }

        return $value;
    }
}
