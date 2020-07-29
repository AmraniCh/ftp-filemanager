<?php

namespace FTPApp\Session;

use FTPApp\Session\Exception\SessionRuntimeException;

class Session
{
    protected static $id;

    public static function setID($id)
    {
        session_id($id);

        if (self::getID() !== $id) {
            throw new SessionRuntimeException("Failed to set session id to [$id].");
        }

        return true;
    }

    public static function setName($name)
    {
        session_name($name);

        if (self::getName() !== $name) {
            throw new SessionRuntimeException("Failed to set session name to [$name].");
        }

        return true;
    }

    public static function getID()
    {
        return session_id();
    }

    public static function getName()
    {
        return session_name();
    }

    public static function setDirectivesConfiguration($options)
    {
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                if (!ini_set('session.' . $key, (int)$value)) {
                    throw new SessionRuntimeException(sprintf(
                        "Cannot set directive [%s] to [%s]",
                        $key,
                        gettype($value) === 'boolean' ? $value ? 'true' : 'false' : $value
                    ));
                }
            }
        }
    }

    public static function start()
    {
        if (self::isNone()) {
            return session_start();
        }

        return false;
    }

    public static function regenerateID($deleteOldSession = true)
    {
        if (self::start()) {
            if (session_regenerate_id()) {
                return session_regenerate_id($deleteOldSession);
            }
        }

        return false;
    }

    public function setCookieParameters($lifetime, $path, $domain, $secure = false, $httpOnly = false)
    {
        if (!session_set_cookie_params($lifetime, $path, $domain, $secure, $httpOnly)) {
            throw new SessionRuntimeException("Unable to set session cookie parameters.");
        }

        return true;
    }

    public function getCookieParameters()
    {
        return session_get_cookie_params();
    }

    public static function isActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public static function isDisabled()
    {
        return session_status() === PHP_SESSION_DISABLED;
    }

    public static function isNone()
    {
        return session_status() === PHP_SESSION_NONE;
    }

    public static function destroy()
    {
        if (Session::isActive()) {
            return session_destroy();
        }

        return false;
    }

    public static function deleteCookie()
    {
        $cookieName = self::getName();
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
            setcookie($cookieName, '', time() - 3600);
        }
    }
}
