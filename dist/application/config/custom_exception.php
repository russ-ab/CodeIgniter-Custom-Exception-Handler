<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['db_use'] = TRUE;                                                   //Use database to save exceptions;
$config['db_exceptions_table'] = 'ci_exceptions';                              //Name of table where the exceptions will be saved

$config['email_send'] = TRUE;                                              // Send email on exception?
$config['email_from_email'] = 'no-reply@app.com';                           // From Email
$config['email_from_name'] = 'APP';                                         // From Name
$config['email_to'] = 'dev@dev.com';                                        // To Email

$config['default_callback'] = function ($message) {
    $prep_message = 'From config file! | ' . $message;
    redirect(base_url('exception_tests?exc_type=Default Callback&msg=' . $prep_message));
};
