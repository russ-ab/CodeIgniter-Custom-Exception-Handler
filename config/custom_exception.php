<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['db_use'] = TRUE;                                                   //Use database to save exceptions;
$config['db_exceptions_table'] = 'exceptions';                              //Name of table where the exceptions will be saved

$config['email_send'] = FALSE;                                              // Send email on exception?
$config['email_from_email'] = 'no-reply@app.com';                           // From Email
$config['email_from_name'] = 'APP';                                         // From Name
$config['email_to'] = 'dev@dev.com';                                        // To Email

$config['default_callback'] = 'exception_tests/custom_exception_message';   // Default callback when a exception happens, define like a route: home/custom_exception