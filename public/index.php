<?php

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

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();

require_once 'Zend/Service/Amazon/S3.php';

$s3 = new Zend_Service_Amazon_S3('AKIAJZPI6TYUPBP73PXQ', 'FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ');

$s3->createBucket("mysterybox_bucket");

$s3->putObject("mysterybox_bucket/myobject", "somedata");

echo $s3->getObject("mysterybox_bucket/myobject");