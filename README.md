# CodeIgniter-Custom-Exception-Handler

Handles caught exceptions, uncaught exceptions and php errors in a single method.

# Installation

1. Enable hooks on application/config/config.php ``$config['enable_hooks'] = TRUE``
2. **ATENTION**: If you are using Hooks add content from config/hooks.php to your file.
3. Copy all files to your project.
4. Update config/custom_exception.php with your preferences.
5. Access <your_app_url>/exception_tests to test.


# Exceptions TABLE

- Run **custom_exception.sql** in your database. If you change table's name remember to update the config/custom_exception.php.
 

# Usage

- Use try/catch on controllers
- Throw exceptions on models/helpers/libraries
- Check the **tests controller** for examples.


### @TODO

- Add threshold to PHP errors severity

_Inspired by: http://thecancerus.com/simple-way-to-add-global-exception-handling-in-codeigniter/_

