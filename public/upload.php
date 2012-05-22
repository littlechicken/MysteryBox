<?php

	s3 = Services_Amazon_S3::getAccount("AKIAJZPI6TYUPBP73PXQ", "FUkx02+w97CjK6oWy36iUy4bqVcpU4YubzGBvIFZ");
	bucket = $s3->getBucket("mysterybox_bucket");
	object = $bucket->getObject($_FILES["fieldname"]["name"]);
	object->acl = "public-read";
	object->contentType = $_FILES["fieldname"]["type"];
	object->data = file_get_contents($_FILES["fieldname"]["tmp_name"]);
	object->save();

/*if (is_uploaded_file($_FILES["fieldname"]["tmp_name"])) {
	Services_Amazon_S3_Stream::register();
	$context = stream_context_create(array(
	
	"s3" => array(
	"access_key_id" => "AKIAJZPI6TYUPBP73PXQ",
	"secret_access_key" => "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",
	"content_type" => $_FILES["fieldname"]["type"],
	"acl" => "public-read")));
	
	copy($_FILES["fieldname"]["tmp_name"],
		"s3://mysterybox_bucket/" . $_FILES["fieldname"]["name"],
		$context);
}*/
?>
