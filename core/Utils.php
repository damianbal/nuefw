<?php

namespace Core;

class Utils
{
    public static function dd($o)
    {
        die("<pre>".var_dump($o)."</pre>");
    }

//TODO: add this class to all views so we can nicely get urls :)
    public static function url($route, $inputs = [])
    {
        //
        $data_str = "index.php?route=" . $route . "&";

        foreach($inputs as $key => $value)
        {
            $data_str .= $key . "=" . $value . "&";
        }

        return $data_str;
    }
}

// Class to be only injected to global view variables
class UtilsViewHelper
{
    public function url($route, $inputs = [])
    {
        echo Utils::url($route, $inputs);
    }
}
