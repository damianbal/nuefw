<?php

namespace App\Controllers;

class ErrorController extends Controller
{
    public function middleware_error()
    {
        $str = "Middleware error: " . \Core\Input::get('middleware_obj') . "<br>";
        $str .= "Error message: " . \Core\Input::get('error_message') . "<br>";

        //return $str;

        return \Core\View::render('errors/error.html', ['error_heading' => 'Middleware',
    'error_message' => $str]);
    }

    public function method_error()
    {
        return \Core\View::render('errors/error.html', ['error_heading' => 'Method not allowed!',
    'error_message' => '']);
    }
}
