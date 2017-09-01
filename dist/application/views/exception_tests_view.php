<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CodeIgniter-Custom-Exception-Handler Tests</title>

    <style type="text/css">

        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        h2 {
            color: #444;
            background-color: transparent;
            font-size: 17px;
            font-weight: normal;
            margin: 0 0 14px 0;
        }

        h3 {
            color: #444;
            background-color: transparent;
            font-size: 15px;
            font-weight: bold;
            margin: 0 0 14px 0;
        }

        pre {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body {
            margin: 0 15px 0 15px;
        }

        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

        .alert {
            width: 50%;
            margin: 20px auto;
            padding: 10px;
            font-weight: bolder;
            text-align: center;
            color: #a94442;
            border: 1px solid #ebccd1;
            box-shadow: 0 0 8px #D0D0D0;
            background-color: #f2dede;
        }
    </style>
</head>
<body>

<?php if ($this->input->get('exc_type') && $this->input->get('msg')) {
    $msg_error = $this->input->get('exc_type') . ' - ' . $this->input->get('msg');
} ?>

<div id="container" class="">
    <h1>CodeIgniter-Custom-Exception-Handler Tests!</h1>

    <div id="body">

        <?php if (isset($msg_error)) { ?>
            <div class="alert"><?php echo $msg_error ?> | <a href="<?php echo base_url('exception_tests'); ?>">Clear</a></div>
        <?php } ?>

        <h2>There are 3 types of exceptions that the library can handle:</h2>

        <h3>Caught exceptions </h3>
        <ul>
            <li>
                <p>With Default Callback <a href="<?php echo base_url('exception_tests/test_catch_exception_default_callback') ?>">Try It!</a></p>
                <pre>
                    /**
                     * Throw a caught exception
                     */
                    try {
                        throw new Exception("Catch Exception");
                    } catch (Exception $ex) {
                        $this->load->library('custom_exception');
                        $this->custom_exception->handle_exception($ex->getFile(), $ex->getLine(), $ex->getMessage());
                    }
                </pre>
            </li>
            <li><p>With Custom Callback <a href="<?php echo base_url('exception_tests/test_catch_exception_custom_callback') ?>">Try It!</a></p>
                <pre>
                    /**
                     * Throw a caught exception
                     */
                    try {
                        throw new Exception("Catch Exception");
                    } catch (Exception $ex) {
                        $this->load->library('custom_exception');
                        $this->custom_exception->handle_exception($ex->getFile(), $ex->getLine(), $ex->getMessage(), array($this, 'handle_exception_callback'));
                    }
                </pre>
            </li>
        </ul>

        <h3>Uncaught exceptions <a href="<?php echo base_url('exception_tests/test_uncaught_exception') ?>">Try It!</a></h3>

        <h3>PHP Errors <a href="<?php echo base_url('exception_tests/test_php_exception') ?>">Try It!</a></h3>

        <p>Please, read the tutorial <a href="https://github.com/russ-ab/CodeIgniter-Custom-Exception-Handler/blob/master/README.md">here</a> for an in-depth explanation of install and usage.</p>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>
</div>

</body>
</html>