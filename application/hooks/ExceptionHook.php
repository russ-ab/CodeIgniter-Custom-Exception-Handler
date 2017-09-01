<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ExceptionHook
{

    /**
     * Set new Exception Handler
     */
    public function SetExceptionHandler()
    {
        set_exception_handler(array($this, 'HandleExceptions'));
    }

    /**
     * Handler to get information about exception and send to custom handler exception library
     * @param Exception $exception
     */
    public function HandleExceptions($exception)
    {
        $CI = &get_instance();
        $CI->load->library('custom_exception');

        $CI->custom_exception->handle_exception($exception->getFile(), $exception->getLine(), "Uncaught Exception");
    }

}
