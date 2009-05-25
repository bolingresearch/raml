<?php
require_once("raml-load.php");

echo $db->escape("It's working!<br />");

//$sql  = "INSERT INTO mls_users (mls_id, first_name, last_name, address, city, state, zipcode, phone) ";
//$sql .= "VALUES (321656, 'Mike', 'Boling', '1234 Main St', 'Bonners Ferry', 'ID', '96080', '(916) 432-3169')";
//$result = $db->query($sql);

$mlsuser = MLSUser::find_by_mls_id(321654);
echo $mlsuser->first_name . " " . $mlsuser->last_name . "<br />";

$db->close_connection();
?>