<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_exception
{

    /**
     * Use database to save exceptions
     * @var boolean
     */
    protected $_db_use;
    /**
     * Name of table where the exceptions will be saved
     * @var string
     */
    protected $_db_exceptions_table;
    /**
     * Send email on exception?
     * @var boolean
     */
    protected $_email_send;
    /**
     * From Email
     * @var string
     */
    protected $_email_from_email;
    /**
     * From Name
     * @var string
     */
    protected $_email_from_name;
    /**
     * To Email
     * @var string
     */
    protected $_email_to;
    /**
     * Default callback when a exception happens
     * @var string
     */
    protected $_default_callback;
    /**
     * Codeigniter Instance
     * @var object
     */
    private $ci;

    /**
     * Class constructor
     *
     * Load CI instance and config variables
     *
     */
    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->helper('url');
        $this->ci->load->config('custom_exception', TRUE);

        $this->_db_use = $this->ci->config->item('db_use', 'custom_exception');
        $this->_db_exceptions_table = $this->ci->config->item('db_exceptions_table', 'custom_exception');
        $this->_email_send = $this->ci->config->item('email_send', 'custom_exception');
        $this->_email_from_email = $this->ci->config->item('email_from_email', 'custom_exception');
        $this->_email_from_name = $this->ci->config->item('email_from_name', 'custom_exception');
        $this->_email_to = $this->ci->config->item('email_to', 'custom_exception');

        $this->_default_callback = $this->ci->config->item('default_callback', 'custom_exception');

    }

    /**
     * Handle an incoming exception
     * @param string $file
     * @param string $line
     * @param string $message
     * @param array $callback
     */
    public function handle_exception($file, $line, $message, $callback = null)
    {
        /*
         * Create an array with all information about the exception
         */
        $log['file'] = $file;
        $log['line'] = $line;
        $log['message'] = $message;
        $log['method'] = $this->ci->input->method(TRUE);
        $log['get'] = json_encode($this->ci->input->get());
        $log['post'] = json_encode($this->ci->input->post());
        $log['files'] = json_encode($_FILES);
        $log['is_ajax'] = ($this->ci->input->is_ajax_request() ? 'Y' : 'N');
        $log['is_cli'] = (is_cli() ? 'Y' : 'N');
        $log['user_agent'] = $this->ci->input->user_agent();

        /*
         * Retrieve user agent and session data
         */
        if (isset($this->ci->session)) {
            $log['session_data'] = json_encode($this->ci->session->userdata());
        } else {
            $log['session_data'] = 'Session Library not loaded.';
        }

        /*
         * Retrieve Stacktrace
         */
        $log['stack_trace'] = nl2br($this->_get_stacktrace());

        /*
         * If Database is loaded get last query and last error
         */
        if (isset($this->ci->db) && isset($this->ci->db->conn_id) && $this->ci->db->conn_id != '') {
            $log['sql_query'] = $this->ci->db->last_query();
            $log['sql_error'] = json_encode($this->ci->db->error());

            /**
             * @IMPORTANT
             *
             * The previous flow was broken.
             * Then a transaction rollback is performed to ensure the integrity of the database.
             */
            $this->ci->db->trans_rollback();

            /*
             * Save on database if configured to
             */
            if ($this->_db_use) {
                /*
                 * Convert arrays to json before insert
                 */
                foreach ($log as $idx => $l) {
                    if (is_array($l)) {
                        $log[$idx] = json_encode($l);
                    }
                }
                /*
                 * Insert
                 */
                $this->ci->db->insert($this->_db_exceptions_table, $log);
            }
        } else {
            $log['sql_query'] = 'Database Library not loaded.';
            $log['sql_error'] = 'Database Library not loaded.';
        }

        /*
         * If environment is production
         *      and send email is TRUE then send email to developers
         * Else show a var_dump and stop execution.
         */
        if (ENVIRONMENT == 'production') {
            if ($this->_email_send) {
                /**
                 * SEND EMAIL
                 */
                $CI =& get_instance();
                $CI->load->helper('inflector');

                $msg = '<h3>An error Occured</h3>';

                foreach ($log as $i => $l) {
                    $msg .= sprintf('<p><strong>%s:</strong> %s</p>', humanize($i), $l);
                }

                $CI->load->library('email');

                $CI->email->from($this->_email_from_email, $this->_email_from_name);
                $CI->email->to($this->_email_to);

                $CI->email->subject("### Exception ### " . $message);
                $CI->email->message($msg);

                $CI->email->send();
            }

            /*
             * Call the callback or redirect to base_url
             */
            if ($callback !== null) {
                call_user_func($callback, $message);
            } else if (!empty($this->_default_callback)) {
                $callback_name = $this->_default_callback;
                $callback_name($message);
            } else {
                redirect(base_url());
            }
        } else {
            set_status_header(500);
            $this->_pretty_dump($log, $log['message']);
            exit;
        }
    }

    /**
     * Get current stacktrace and return a pretty string
     * @return string
     */
    private function _get_stacktrace()
    {

        $trace = debug_backtrace();
        $remove_caller = array_shift($trace);

        $trace_full = PHP_EOL;
        foreach ($trace as $entry_id => $entry) {
            $entry['file'] = isset($entry['file']) ? $entry['file'] : '-';
            $entry['line'] = isset($entry['line']) ? $entry['line'] : '-';
            if (empty($entry['class'])) {
                $trace_full .= sprintf('#%3s. %s() %s:%s', $entry_id + 1, $entry['function'], $entry['file'], $entry['line']) . PHP_EOL;
            } else {
                $trace_full .= sprintf('#%3s. %s->%s() %s:%s', $entry_id + 1, $entry['class'], $entry['function'], $entry['file'], $entry['line']) . PHP_EOL;
            }
        }

        return $trace_full;
    }

    /**
     * Functions to dump variables to the screen, in a nicley formatted manner.
     * @author Joost van Veen
     * @version 1.0
     * @param $var
     * @param string $label
     * @param bool $echo
     * @return mixed|string
     */
    private function _pretty_dump($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        // Output
        if ($echo == TRUE) {
            echo $output;
        } else {
            return $output;
        }
    }

}
