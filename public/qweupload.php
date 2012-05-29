<?php

//require_once 'MysteryBox/Credentials.php';
//require_once 'Zend/Service/Amazon/S3.php';

Zend_Loader::loadClass('Credentials');
Zend_Loader::loadClass('Zend_Service_Amazon_S3');

$creds = new Credentials;
$s3 = new Zend_Service_Amazon_S3($creds->getCredential('amazon', 'accessKey'),
                                 $creds->getCredential('amazon', 'secretKey'));
		
//$s3 = new Zend_Service_Amazon_S3('AKIAJZPI6TYUPBP73PXQ', 'FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ');
 
$s3->createBucket("mysterybox_bucket");
 
$s3->putObject("mysterybox_bucket/myobject", "somedata");
 
echo $s3->getObject("mysterybox_bucket/myobject");