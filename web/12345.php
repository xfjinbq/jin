<?php
$u="admin"; //用户名
$p="123456"; //密码
$firstRun = 1;
if (php_sapi_name() == "cli") {
	$dispNewline = "\n";
} else {
	$dispNewline = "<br>";
}

function cryptPass($unenc_username, $unenc_password) {
	$encrypted = $unenc_username . ":" . crypt($unenc_password, base64_encode($unenc_password));
	return $encrypted;
}

function cryptPassToFile( $username, $password) {
	global $firstRun;
	global $dispNewline;
	if ($firstRun == 1) {
		if (file_exists(".htpasswd")) {
			unlink(".htpasswd");
		}
	
		$firstRun = 0;
	}
	file_put_contents(".htpasswd", cryptPass($username, $password) . "\n", FILE_APPEND);
}

cryptPassToFile($u ,  $p);
$s='AuthName "Restricted Area"'.PHP_EOL.'AuthType Basic'.PHP_EOL.'AuthUserFile '.$_SERVER[SERVER_ROOT].'/.htpasswd'.PHP_EOL.'AuthGroupFile /dev/null'.PHP_EOL.'require valid-user';
file_put_contents('.htaccess',$s);
?>
