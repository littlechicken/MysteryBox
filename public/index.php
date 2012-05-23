<?php
    print("Mysterybox is here! ;)");
	
	if (class_exists('S3'))
	{
		print("s3 class exist");
	}
	else
	{
		print("warning: s3 class not exists");
	}
	
	if(isset($_FILES['theFile']))
	{
	    print("Success!");
	    print("tmpName: " . $_FILES['theFile']['tmp_name'] . " ");
      	print("size: " . $_FILES['theFile']['size'] . " ");
      	print("mime: " . $_FILES['theFile']['type'] . " ");
      	print("name: " . $_FILES['theFile']['name'] . " ");
	
		s3 = Services_Amazon_S3::getAccount("AKIAJZPI6TYUPBP73PXQ", "FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ");
		bucket = $s3->getBucket("mysterybox_bucket");
		object = $bucket->getObject($_FILES["theFile"]["name"]);
		object->acl = "public-read";
		object->contentType = $_FILES["theFile"]["type"];
		object->data = file_get_contents($_FILES["theFile"]["tmp_name"]);
		object->save();

		/*if (is_uploaded_file($_FILES["theFile"]["tmp_name"])) {
			Services_Amazon_S3_Stream::register();
			$context = stream_context_create(array(
		
			"s3" => array(
		
			"access_key_id" => "AKIAJZPI6TYUPBP73PXQ",
			"secret_access_key" => "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",
			"content_type" => $_FILES["theFile"]["type"],
			"acl" => "public-read")));
	
			copy($_FILES["theFile"]["tmp_name"],
				"s3://mysterybox_bucket/" . $_FILES["theFile"]["name"],
				$context);*/
		}	
	}
	else
	{
	    print("Request without file upload!");
	}
?>
