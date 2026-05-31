<?php

// SET DEFAULT TIMEZONE
date_default_timezone_set("Europe/Berlin");

// WRITE ONLY LAST RECEIVED IP TO FILE
	$ip = $_SERVER['REMOTE_ADDR'] . ' - ' . date('d.m.Y - H:i:s');
	file_put_contents('ip.txt', $ip);


/* WRITE LAST IP IN A NEW LINE AT THE END OF THE FILE
	$ip = "$_SERVER[REMOTE_ADDR]" . " - " . date('Y-m-d H:i:s');
	file_put_contents('ip.txt', $ip . PHP_EOL, FILE_APPEND);
*/

/* WRITE LAST IP IN A NEW LINE AT THE *TOP* OF THE FILE
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    	$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
    	$ip = $_SERVER['REMOTE_ADDR'];
	}

	$prepend = $ip . ' - ' . date('d.m.Y - H:i:s') . "\n";
	$file = 'ip.txt';
	$filecontents = file_get_contents($file);
	file_put_contents($file, $prepend . $filecontents);

	// SHOW WHAT IS WRITTEN TO FILE (DEBUGGING ONLY)
	echo '<pre>';
	echo $filecontents;
	echo '</pre>';
*/

?>
