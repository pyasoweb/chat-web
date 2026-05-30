<?PHP
// IP Address Logger
/* to use this simply put this code into a php file named
log.php, then either include it into your main page website
or just direct the person to this page. make sure you have a
log.txt file in your root directory of the server for it to save
all ip logs too. */

$ip = getenv("REMOTE_ADDR");
$filename = "log.txt";
$myfile = fopen($filename, "a+") or die("Couldn't open file");
fwrite($myfile, $ip) or die("Couldn't write to file");
?>
