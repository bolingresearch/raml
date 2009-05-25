<?php
/*
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
$db_pass 	= "lilyb2007";
$db_name 	= "djboling_raml";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// MLS Users
*/

/**
 * Local directory details
 */
$local_temp_dir = dirname(__FILE__)."/temp/";
$local_images_dir = dirname(__FILE__)."/images/";


// FTP
$ftp_host = "idx.fnismls.com";
$ftp_user = "tehamamls_djboling";
$ftp_pass = "2dk9j2ipcz";
$ftp_dir = "IDX/";

/**
 * Connect to the FTP Server
 */
$conn = ftp_connect($ftp_host) or die("ERROR: Cannot connect to FTP server.");
ftp_login($conn, $ftp_user, $ftp_pass) or die("ERROR: Cannot login to FTP server");
ftp_chdir($conn, $ftp_dir);


/**
 * Retrieve list of files on the server.
 */
$list = ftp_nlist($conn, ".");
natsort($list);


/**
 * Separate image archives from data files.
 */
$listingdata_files = array();
$image_archives = array();
$i = $j = 0;
foreach ($list as $remote_file) {
    if (preg_match("/listings/", $remote_file)) {
        $listingdata_files[$i] = $remote_file;
        $i++;
    }
    else if (preg_match("/pics/", $remote_file)) {
            $image_archives[$j] = $remote_file;
            $j++;
        }
}


/**
 * Files to download.
 */
$date = new DateTime(date("Y-m-d"));  // today
$date->modify("-1 day");            // yesterday
$formatted_date = $date->format("Ymd");
$files2download = $listingdata_files;
foreach ($image_archives as $image_archive) {
    if ( preg_match("/$formatted_date/", $image_archive)) {
        $files2download[] = $image_archive;
    }
}

/**
 * Download and extract data files and image archives.
 */
require_once("functions/get_idx_files.php");
get_idx_files($conn, $local_temp_dir, $local_images_dir, $files2download);


/**
 * Disconnect from the FTP server.
 */
ftp_close($conn);
?>