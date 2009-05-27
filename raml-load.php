<?php

define('ABSPATH', dirname(__FILE__) . "/");
define('CLASS_PATH', ABSPATH . "classes/");
define('FUNC_PATH', ABSPATH . "functions/");
define('TEMP_PATH', ABSPATH . "temp/");

// Load configuration settings
require_once(ABSPATH . "raml-config.php");

// Load classes
require_once(CLASS_PATH . "database.php");
require_once(CLASS_PATH . "database-object.php");
require_once(CLASS_PATH . "mlsuser.php");
require_once(CLASS_PATH . "property.php");

// Load functions
require_once(FUNC_PATH . "misc.php");
?>