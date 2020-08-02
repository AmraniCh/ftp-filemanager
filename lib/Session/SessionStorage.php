<?php

namespace FTPApp\Session;

class SessionStorage
{
    public function setVariable($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getVariable($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }

    public function show()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    public function unsetVars()
    {
        if (isset($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
        }
    }
}
