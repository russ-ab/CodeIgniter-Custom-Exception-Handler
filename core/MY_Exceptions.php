<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Exceptions class.
 *
 * @extends CI_Exceptions
 */
class MY_Exceptions extends CI_Exceptions
{

    /**
     * Extend log_exception to send to handle custom exceptions library
     *
     * @access public
     * @param string $severity
     * @param string $message
     * @param string $filepath
     * @param int $line
     * @return void
     */
    function log_exception($severity, $message, $filepath, $line)
    {

        $CI = &get_instance();
        $CI->load->library('custom_exception');

        $final_message = sprintf("PHP | %s | %s", $severity, $message);
        $CI->custom_exception->handle_exception($filepath, $line, $final_message);
    }

}

/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */