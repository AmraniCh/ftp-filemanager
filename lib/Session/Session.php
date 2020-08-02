<?php

namespace FTPApp\Session;

use FTPApp\Session\Exception\SessionRuntimeException;

class Session
{
    protected $options;

    /**
     * Session constructor.
     *
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
        $this->setDirectivesConfiguration();
    }

    public function setID($id)
    {
        session_id($id);

        if ($this->getID() !== $id) {
            throw new SessionRuntimeException("Failed to set session id to [$id].");
        }

        return true;
    }

    public function setName($name)
    {
        session_name($name);

        if ($this->getName() !== $name) {
            throw new SessionRuntimeException("Failed to set session name to [$name].");
        }

        return true;
    }

    public function getID()
    {
        return session_id();
    }

    public function getName()
    {
        return session_name();
    }

    public function start()
    {
        if ($this->isNone()) {
            session_name(ini_get('session.name'));
            return session_start();
        }

        return false;
    }

    public function regenerateID($deleteOldSession = true)
    {
        if ($this->start()) {
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

    public function isActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function isDisabled()
    {
        return session_status() === PHP_SESSION_DISABLED;
    }

    public function isNone()
    {
        return session_status() === PHP_SESSION_NONE;
    }

    public function destroy()
    {
        if (Session::isActive()) {
            return session_destroy();
        }

        return false;
    }

    public function deleteCookie()
    {
        $cookieName = $this->getName();
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
            setcookie($cookieName, '', time() - 3600);
        }
    }

    protected function setDirectivesConfiguration()
    {
        if (!empty($this->options)) {
            foreach ($this->options as $key => $value) {
                if (ini_set('session.' . $key, $value) === false) {
                    throw new SessionRuntimeException(sprintf(
                        "Cannot set directive [%s] to [%s]",
                        $key,
                        gettype($value) === 'boolean' ? $value ? 'true' : 'false' : $value
                    ));
                }
            }
        }
    }
}
