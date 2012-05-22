<?php
if (is_uploaded_file($_FILES["fieldname"]["tmp_name"])) {
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
}
