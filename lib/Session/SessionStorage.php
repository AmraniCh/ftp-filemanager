<?php

namespace FTPApp\Session;

class SessionStorage
{
    public static function setVariable($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getVariable($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }

    public static function show()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    public static function unsetVars()
    {
        if (isset($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
        }
    }
}
