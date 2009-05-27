<?php
require_once ("raml-load.php");


$db_property = new Property(360);


echo "<hr />";
echo "<pre>";
print_r($db_property);
echo "</pre>";

echo "<br />";

$db->close_connection();
?>
