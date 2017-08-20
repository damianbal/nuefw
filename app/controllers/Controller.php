<?php

namespace App\Controllers;

use \Core\Middleware;

class Controller
{
    /**
     *
     * @param $route string
     * @param $inputs  data
     *
     * @return void
     */
    public function redirect($route, $inputs = []) : void
    {
        $data_str = "index.php?route=" . $route . "&";

        foreach($inputs as $key => $value)
        {
            $data_str .= $key . "=" . $value . "&";
        }

        echo "<script>document.location='".$data_str."';</script>";
    }

    public function redirect_back()
    {
        $this->redirect(\Core\Session::session('last_route'));
    }

    /**
     *
     * @param $c \Core\Middleware
     * @param $data array
     *
     * @return void
     */
    public function middleware($c, $data = []) : void
    {
        $middleware_obj = new $c();

        $middleware_obj->setData($data);

        if($middleware_obj->run() == true)
        {

        }
        else
        {
            $this->redirect('middleware_error', ['middleware_obj' => $c,
                                                 'error_message' => $middleware_obj->error_message()]);
        }
    }
}
