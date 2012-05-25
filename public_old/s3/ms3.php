<?php

class MS3 {
	const BUCKET_NAME = 'mysterybox_bucket';
	const AMAZON_ID = 'AKIAJZPI6TYUPBP73PXQ';
	const AMAZON_SECRET_ID = 'FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ';

	//private static $s3;

	/*public function __construct() {
         //include the S3 class
        if (!class_exists('S3'))require_once('S3.php');
            
        //AWS access info
        if (!defined('awsAccessKey')) define('awsAccessKey', $AMAZON_ID);
        if (!defined('awsSecretKey')) define('awsSecretKey', $AMAZON_SECRET_ID);
            
        //instantiate the class
	    $s3 = new S3(awsAccessKey, awsSecretKey);
	}*/

/*	public static function putFileToAmazon($fileTempName, $fileName) {
    	//create a new bucket
        $s3->putBucket($BUCKET_NAME, S3::ACL_PUBLIC_READ);

        //move the file
        if ($s3->putObjectFile($fileTempName, $BUCKET_NAME, $fileName, S3::ACL_PUBLIC_READ)) {
        	echo "<strong>We successfully uploaded your file.</strong>";
        }else{
            echo "<strong>Something went wrong while uploading your file... sorry.</strong>";
        }
	}
*/
?>
