<?php

namespace App\Middleware;
use Core\Input;

class HasInputs extends \Core\Middleware
{
    protected $inputs_missing = [];

    public function error_message()
    {
        $str = "Inputs missing: ";
        foreach($this->inputs_missing as $missing_input) {
            $str .= $missing_input;
            $str .= " ";
        }
        return $str;
    }

    public function run() : bool
    {
        $inputs = $this->data['inputs'];

        $missing = false;

        foreach($inputs as $input) {
            if(\Core\Input::has($input) == true)
            {
                // ok
            }
            else
            {
                $this->inputs_missing[] = $input;
                $missing = true;
            }
        }

        if($missing == true)
        {
            return false;
        }

        return true;
    }
}
