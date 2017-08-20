<?php

namespace Core;

class Application
{
    public static $config = null;
    public static $kernel = null;

    public static function setup($c, $k)
    {
        static::$config = $c;
        static::$kernel = $k;
    }

    public static function register() {}

    public static function getConfig() { return static::$config; }
    public static function getKernel() { return static::$kernel; }
}
