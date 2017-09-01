<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exception_tests extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        /*
         * Load Tests view
         */
        $this->load->view('exception_tests_view');
    }

    /**
     * Force PHP error
     */
    public function test_php_exception()
    {
        /*
         * Strlen expects 1 parameters
         */
        $string = strlen();
    }

    /**
     * Force Uncaught Exception
     *
     * @throws Exception
     */
    public function test_uncaught_exception()
    {
        /*
         * Throw an uncaught exception
         */
        throw new Exception("Uncaught Exception");
    }

    /**
     * Force Catch Exception with Default Callback
     */
    public function test_catch_exception_default_callback()
    {
        /**
         * Throw a caught exception
         */
        try {
            throw new Exception("Catch Exception");
        } catch (Exception $ex) {
            $this->load->library('custom_exception');
            $this->custom_exception->handle_exception($ex->getFile(), $ex->getLine(), $ex->getMessage());
        }
    }


    /**
     * Force Catch Exception with Custom Callback
     */
    public function test_catch_exception_custom_callback()
    {
        /**
         * Throw a caught exception
         */
        try {
            throw new Exception("Catch Exception");
        } catch (Exception $ex) {
            $this->load->library('custom_exception');
            $this->custom_exception->handle_exception($ex->getFile(), $ex->getLine(), $ex->getMessage(), array($this, 'handle_exception_callback'));
        }
    }

    /**
     * Callback called by test method "test_catch_exception_custom_callback"
     * @param string $message Received message from Custom Exception Handler Library
     */
    public function handle_exception_callback($message)
    {
        redirect(base_url('exception_tests?exc_type=Custom Callback&msg=' . $message));
    }

    /**
     * Default callback from config/custom_exception.php
     * @param string $message Received message from Custom Exception Handler Library
     */
    public function custom_exception_message($message)
    {
        redirect(base_url('exception_tests?exc_type=Default Callback&msg=' . $message));
    }

}
