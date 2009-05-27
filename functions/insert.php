<?php
require_once ("../raml-load.php");

$data_file = TEMP_PATH."listings-residential.txt";

// Get Rows (Property Data)
$lines = file($data_file, FILE_IGNORE_NEW_LINES);
$count = 0;
foreach ($lines as $line)
{
    $fields = explode("\t", $line);
    $address = array ();
    $address['street'] = $fields[5].' '.$fields[6].' '.$fields[7];
    $address['city'] = $fields[9];
    $address['state'] = $fields[10];
	$property = new Property($address);
	$new_id = $property->insert();
	if($new_id != false) {
		echo "New Property, ID# " .$new_id . "<br />";
	} else {
		echo "Failed to insert new property<br />";
	}
    unset ($address);
	$count++;
	if($count == 50) { break; }
}
?>
