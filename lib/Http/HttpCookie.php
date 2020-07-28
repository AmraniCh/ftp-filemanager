<?php

namespace FTPApp\Http;

final class HttpCookie
{
    const EXPIRE_SESSION = 0;
    const CURRENT_PATH   = '';
    const WHOLE_DOMAIN   = '';
    const SAMESITE_STRICT = 'Strict';
    const SAMESITE_LAX = 'Lax';
    const SAMESITE_NONE = 'None';

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /** @var int */
    private $expire;

    /** @var string */
    private $path;

    /** @var string */
    private $domain;

    /** @var bool */
    private $secure;

    /** @var bool */
    private $httpOnly;

    /** @var string */
    private $sameSite;

    /**
     * Cookie constructor.
     *
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httpOnly
     * @param string $sameSite
     */
    public function __construct(
        $name,
        $value,
        $expire = self::EXPIRE_SESSION,
        $path = self::CURRENT_PATH,
        $domain = self::WHOLE_DOMAIN,
        $secure = false,
        $httpOnly = false,
        $sameSite = self::SAMESITE_NONE)
    {
        $this->name     = $name;
        $this->value    = $value;
        $this->expire   = $expire;
        $this->path     = $path;
        $this->domain   = $domain;
        $this->secure   = $secure;
        $this->httpOnly = $httpOnly;
        $this->sameSite = $sameSite;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param int $expire
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param bool $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    }

    /**
     * @param bool $httpOnly
     */
    public function setHttpOnly($httpOnly)
    {
        $this->httpOnly = $httpOnly;
    }

    /**
     * @param string $sameSite
     */
    public function setSameSite($sameSite)
    {
        $this->sameSite = $sameSite;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @return bool
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * @return string
     */
    public function getSameSite()
    {
        return $this->sameSite;
    }
}