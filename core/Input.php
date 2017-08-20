<?php

namespace Core;

class Input
{
    public static $config = null;

    /**
     *
     * @param $input_name string
     *
     * @return string
     */
    public static function file($input_name)
    {
        if(!empty($_FILES[$input_name]))
        {
            $upload_dir = "app/public/uploads/";
            $name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES[$input_name]["name"]);
            $parts = pathinfo($name);
            $new_name = sha1($parts['filename']) . "." . $parts['extension'];
            $success = move_uploaded_file($_FILES[$input_name]['tmp_name'], $upload_dir . $new_name);
            return $upload_dir . $new_name;
        }
    }

    /**
     *
     * @param $input_name string
     *
     * @return string
     */
    public static function photo($input_name)
    {
        if(!empty($_FILES[$input_name]))
        {
            $upload_dir = "app/public/uploads/";
            $name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES[$input_name]["name"]);
            $parts = pathinfo($name);
            $new_name = sha1($parts['filename']) . "." . $parts['extension'];

            if(in_array($parts['extension'], ['png', 'jpg', 'gif', 'jpeg']))
            {
                $success = move_uploaded_file($_FILES[$input_name]['tmp_name'], $upload_dir . $new_name);
                return $upload_dir . $new_name;
            }
        }
    }

    /**
     * Returns input value GET or POST
     *
     * @param $name string
     *
     * @return string
     */
    public static function get($name) : string
    {
        $request_method = $_SERVER['REQUEST_METHOD'];

        if($request_method == 'POST')
        {
            return $_POST[$name];
        }
        else if($request_method == 'GET')
        {
            return $_GET[$name];
        }

        return '';
    }

    /**
     *
     * @param $name string
     *
     * @return bool
     */
    public static function has($name) : bool
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            return isset($_POST[$name]) == true;
        }
        else if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            return isset($_GET[$name]) == true;
        }

        return false;
    }
}
