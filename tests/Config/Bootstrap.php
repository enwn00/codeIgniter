<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

$paths = new App\Config\Paths();

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', $_SERVER['CI_ENV'] ?? 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
{
    case 'local':
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        break;
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
        else
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
// The directory name, relative to the "controllers" folder.  Leave blank
// if your controller is not in a sub-folder within the "controllers" folder
// $routing['directory'] = '';

// The controller class file name.  Example:  mycontroller
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($paths->systemDirectory)) !== FALSE)
{
    $paths->systemDirectory = $_temp.'/';
}
else
{
    // Ensure there's a trailing slash
    $paths->systemDirectory = rtrim($paths->systemDirectory, '/').'/';
}

// Is the system path correct?
if ( ! is_dir($paths->systemDirectory))
{
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system folder
define('BASEPATH', str_replace('\\', '/', $paths->systemDirectory));

// Path to the front controller (this file)
define('FCPATH', dirname(__FILE__).'/');

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

define('ROOTPATH', $paths->rootDirectory);

// The path to the "application" folder
if (is_dir($paths->appDirectory))
{
    if (($_temp = realpath($paths->appDirectory)) !== FALSE)
    {
        $paths->appDirectory = $_temp;
    }

    define('APPPATH', $paths->appDirectory.DIRECTORY_SEPARATOR);
}
else
{
    if ( ! is_dir(BASEPATH.$paths->appDirectory.DIRECTORY_SEPARATOR))
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3); // EXIT_CONFIG
    }

    define('APPPATH', BASEPATH.$paths->appDirectory.DIRECTORY_SEPARATOR);
}

// The path to the "views" folder
if ( ! is_dir($paths->viewDirectory))
{
    if ( ! empty($paths->viewDirectory) && is_dir(APPPATH.$paths->viewDirectory.DIRECTORY_SEPARATOR))
    {
        $paths->viewDirectory = APPPATH.$paths->viewDirectory;
    }
    elseif ( ! is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3); // EXIT_CONFIG
    }
    else
    {
        $paths->viewDirectory = APPPATH.'views';
    }
}

if (($_temp = realpath($paths->viewDirectory)) !== FALSE)
{
    $paths->viewDirectory = $_temp.DIRECTORY_SEPARATOR;
}
else
{
    $paths->viewDirectory = rtrim($paths->viewDirectory, '/\\').DIRECTORY_SEPARATOR;
}

define('VIEWPATH', $paths->viewDirectory);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once $paths->testsDirectory . '/Config/CodeIgniter.php';
