<?php

namespace Core;

class Session
{
    /**
     *
     * @param $s string
     *
     * @return string
     */
    public static function session($s)
    {
        if(is_array($s))
        {
            foreach($s as $key => $value)
            {
                $_SESSION[$key] = $value;
            }
        }
        else
        {
            return $_SESSION[$s];
        }
    }

    /**
     *
     * @param $s string
     *
     * @return bool
     */
    public static function has($s) : bool
    {
        return (isset($_SESSION[$s]) == true);
    }
}
