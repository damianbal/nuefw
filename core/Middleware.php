<?php

namespace Core;

class Middleware
{
    protected $data = [];

    /**
     *
     * @return string
     */
    public function error_message() { return "<span style='color:red;'>Middleware error_message() not defined!</span>"; }

    /**
     *
     * @return bool
     */
    public function run() { return true; }

    /**
     *
     * @param $d array
     *
     * @return void
     */
    public function setData($d) : void
    {
        $this->data = $d;
    }

    /**
     *
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }
}
