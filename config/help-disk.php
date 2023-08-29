<?php
return [
	"api_url"  =>  env("HELP_DISK_API_URL"),
	"access_token"  =>  env("HELP_DISK_ACCESS_TOKEN"),
	"category_token"  => [
		"inquiries_token"  =>  env("HELP_DISK_INQUIRY_TOKEN"),
		"complaints_token"  =>  env("HELP_DISK_COMPLAINT_TOKEN")
	]
];
