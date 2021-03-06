<?php

date_default_timezone_set('Europe/Amsterdam');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Version **/

require_once 'Versioning.php';

/** Zend_Application */

require_once 'Zend/Application.php';
require_once 'Zend/Service/Amazon/S3.php';

/** Facebook **/

require_once 'Facebook/base_facebook.php';
require_once 'Facebook/facebook.php';

/** Sendgrid **/

require_once 'Mail/SendGrid_loader.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
