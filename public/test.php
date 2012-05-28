<?php

require_once 'Zend/Service/Amazon/S3.php';
 
$s3 = new Zend_Service_Amazon_S3('AKIAJZPI6TYUPBP73PXQ', 'FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ');
 
$s3->createBucket("mysterybox_bucket");
 
$s3->putObject("mysterybox_bucket/myobject", "somedata");
 
echo $s3->getObject("mysterybox_bucket/myobject");