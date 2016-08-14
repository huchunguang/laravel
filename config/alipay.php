<?php
return [ 
		'partner' => '2088802807619823',
		'seller_id' => '2088802807619823',
		'key' => 'k2zu8i7h9enbkafsvtfrgdcuy1n273qn',
		'notify_url' => "http://商户网址/create_direct_pay_by_user-PHP-UTF-8/notify_url.php",
		'return_url' => "http://商户网址/create_direct_pay_by_user-PHP-UTF-8/return_url.php",
		'sign_type' => strtoupper ( 'MD5' ),
		'input_charset' => strtolower ( 'utf-8' ),
		'cacert' => getcwd () . '\\cacert.pem',
		'transport' => 'http',
		'payment_type' => "1",
		'service' => "create_direct_pay_by_user",
		'anti_phishing_key' => "",
		'exter_invoke_ip' => "" 
];
