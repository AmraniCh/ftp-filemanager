<?php


namespace FTPApp\Http;


class CookiesFactory
{
    protected $registry;

    /**
     * CookiesFactory constructor.
     *
     * @param array ...
     */
    public function __construct()
    {
        $this->registry = func_get_args();
    }

    public function factory()
    {
        $cookies = [];

        if (!empty($this->registry)) {
            foreach ($this->registry as $cookiesArray) {
                $cookies[] = new HttpCookie(
                    $cookiesArray['name'],
                    $cookiesArray['value'],
                    isset($cookiesArray['expire']) ? $cookiesArray['expire'] : HttpCookie::EXPIRE_SESSION,
                    isset($cookiesArray['path']) ? $cookiesArray['path'] : HttpCookie::CURRENT_PATH,
                    isset($cookiesArray['domain']) ? $cookiesArray['domain'] : HttpCookie::WHOLE_DOMAIN,
                    isset($cookiesArray['secure']) ? $cookiesArray['secure'] : false,
                    isset($cookiesArray['httpOnly']) ? $cookiesArray['httpOnly'] : false,
                    isset($cookiesArray['sameSite']) ? $cookiesArray['sameSite'] : HttpCookie::SAMESITE_NONE
                );
            }
        }

        return $cookies;
    }
}