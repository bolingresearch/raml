<?php
// Parse data file
$file 	= dirname(__FILE__). "/temp/users.txt";
$lines 	= file($file, FILE_IGNORE_NEW_LINES);

$sql = 'INSERT INTO `djboling_raml`.`mls_users` ';
foreach ($lines as $line) {
	$columns = explode("\t", $line);
	$sql .= '(`id`, `mls_id`, `first_name`, `last_name`, `address`, `address2`, `city`, `state`, `zipcode`, `phone`) VALUES (\'\', \'1234\', \'Dustin\', \'Boling\', \'13822 Claremont St\', NULL, \'Westminster\', \'CA\', \'92683\', \'(714) 795-2266\');';
}


// MySQL
$db_host 	= "localhost";
$db_user 	= "djboling_raml";
$db_pass 	= "djboling_lilyb2007";
$db_name 	= "djboling_raml";


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// MLS Users




// FTP
$ftp_host = "idx.fnismls.com";
$ftp_user = "tehamamls_djboling";
$ftp_pass = "2dk9j2ipcz";
$ftp_dir = "IDX/";
?>
