<?php

session_save_path(ROOT_DIR . '\tmp');
if (!isset($_SESSION)) {
    session_start();
}

class SessionManager
{

    public static function save($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function load($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            throw new Exception("key '$key' not defined in session", MyExceptions::SESSION_NO_KEY);
        }
    }
}
