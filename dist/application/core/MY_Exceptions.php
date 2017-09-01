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

        $final_message = sprintf("PHP | %s | %s", $this->_get_friendly_severity_type($severity), $message);
        $CI->custom_exception->handle_exception($filepath, $line, $final_message);
    }

    private function _get_friendly_severity_type($type)
    {
        switch ($type) {
            case E_ERROR: // 1 //
                return 'E_ERROR';
            case E_WARNING: // 2 //
                return 'E_WARNING';
            case E_PARSE: // 4 //
                return 'E_PARSE';
            case E_NOTICE: // 8 //
                return 'E_NOTICE';
            case E_CORE_ERROR: // 16 //
                return 'E_CORE_ERROR';
            case E_CORE_WARNING: // 32 //
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR: // 64 //
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING: // 128 //
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR: // 256 //
                return 'E_USER_ERROR';
            case E_USER_WARNING: // 512 //
                return 'E_USER_WARNING';
            case E_USER_NOTICE: // 1024 //
                return 'E_USER_NOTICE';
            case E_STRICT: // 2048 //
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: // 8192 //
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384 //
                return 'E_USER_DEPRECATED';
        }
        return "";
    }

}

/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */