<?php
//require_once(ABSPATH . "classes/database.php");

class MLSUser extends DatabaseObject {
	
	protected static $table_name = 'mls_users';
	public $id;
	public $mls_id;
	public $first_name;
	public $last_name;
	public $phone;
	
	public function __construct() {
		
	}
	
	// Common Database Methods
	public static function find_all() {
		global $db;
		$result_set = self::find_by_sql("SELECT * FROM " . self::$table_name);
		return $result_set;
	}
	
	public static function find_by_mls_id($mls_id=0) {
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE mls_id={$mls_id}");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="") {
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while ($row = $db->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	private static function instantiate($record) {
		$object = new self;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this); // fyi: includes private variables too.
		// we just want the the keys, not concerned with the values.
		return array_key_exists($attribute, $object_vars);
	}
}
?>