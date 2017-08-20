<?php

namespace Core;

class View
{
    public static $twig_engine = null;
    public static $globals     = [];

    /**
     *
     * @param $key string
     * @param $data mixed
     *
     * @return void
     */
    public static function set($key, $value) : void
    {
        View::$globals[$key] = $value;
    }

    /**
     * Returns HTML view
     *
     * @param $view string
     * @param $data array
     *
     * @return string
     */
    public static function render($view, $data = [])
    {
        if(View::$twig_engine == null) throw new \Exception("Twig engine must be set before use!");

        if(View::$twig_engine != null)
        {
            $template_data = array_merge($data, View::$globals);

            return View::$twig_engine->render($view, $template_data);
        }
    }
}
