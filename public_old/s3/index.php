<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>S3 test upload</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

<body>
    	<?php
			if (!class_exists('MS3'))require_once('ms3.php');	
			$ms3 = new MS3();

			if(isset($_POST['Submit'])) {
				
				$fileName = $_FILES['theFile']['name'];
				$fileTempName = $_FILES['theFile']['tmp_name'];

				if ($ms3->putFileToAmazon($fileTempName, $fileName)) {
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

	$ms3->showAmazonFiles();
	// Get the contents of our bucket
	$contents = $s3->getBucket($bucket_name);
	foreach ($contents as $file){
	
		$fname = $file['name'];
		$furl = "http://mysterybox_bucket.s3.amazonaws.com/".$fname;
		
		//output a link to the file
		echo "<a href=\"$furl\">$fname</a><br />";
	}
?>
</body>
</html>
