<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>S3 tutorial</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

<body>
    	<?php
    		require_once 'Credentials.php';
    	
    		$creds = new Credentials;
    		$s3 = new Zend_Service_Amazon_S3($creds->getCredential('amazon', 'accessKey'),
    			$creds->getCredential('amazon', 'secretKey'));
    	    	
			//include the S3 class
			if (!class_exists('MysteryBoxS3'))require_once('MysteryBoxS3.php');
			
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJZPI6TYUPBP73PXQ');
			if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
			//instantiate the class
			$s3 = new MysteryBoxS3(awsAccessKey, awsSecretKey);
			
			//check whether a form was submitted
			if(isset($_POST['Submit'])){
			
				//retreive post variables
				$fileName = $_FILES['theFile']['name'];
				$fileTempName = $_FILES['theFile']['tmp_name'];
				
				//create a new bucket
				$s3->putBucket("mysterybox_bucket", MysteryBoxS3::ACL_PUBLIC_READ);
				
				//move the file
				if ($s3->putObjectFile($fileTempName, "mysterybox_bucket", $fileName, MysteryBoxS3::ACL_PUBLIC_READ)) {
					echo "<strong>We successfully uploaded your file.</strong>";
				}else{
					echo "<strong>Something went wrong while uploading your file... sorry.</strong>";
				}
			}
		?>
<h1>Upload a file</h1>
<p>Please select a file by clicking the 'Browse' button and press 'Upload' to start uploading your file.</p>
   	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <input name="theFile" type="file" />
      <input name="Submit" type="submit" value="Upload">
	</form>
<h1>All uploaded files</h1>
<?php
	// Get the contents of our bucket
	$contents = $s3->getBucket("mysterybox_bucket");
	foreach ($contents as $file){
	
		$fname = $file['name'];
		$furl = "http://mysterybox_bucket.s3.amazonaws.com/".$fname;
		
		//output a link to the file
		echo "<a href=\"$furl\">$fname</a><br />";
	}
?>
</body>
</html>