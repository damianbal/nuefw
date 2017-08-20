<?php

namespace Core\Utils;

class Hash
{
    /**
     *
     * @param $str string
     *
     * @return string
     */
    public static function hash($str) : string
    {
        return password_hash($str, PASSWORD_BCRYPT_DEFAULT_COST);
    }

    /**
     *
     * @param $str string
     * @param $hashed_str string
     *
     * @return bool
     */
    public static function verify($str, $hashed_str) : bool
    {
        if (password_verify($str, $hashed_str))
        {
            return true;
        }

        return false;
    }
}
