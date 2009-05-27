<?php
class Agent {
	public $id;
	public $mls_id;
	public $office_id;
	public $first_name;
	public $last_name;
	public $phone;
	// not in db table
	public $full_name;
	
	public function __construct() {
		
	}
	
	private static function instantiate($record) {
		$object = new self;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		$object->full_name = $object->first_name . " " . $object->last_name;
		return $object;
	}
	
	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this); // fyi: includes private variables too.
		// we just want the the keys, not concerned with the values.
		return array_key_exists($attribute, $object_vars);
	}
	
	public static function get_by_mls_id($mls_id = 0) {
		$sql  = "SELECT * FROM agents, offices, properties ";
		$sql .= "WHERE agents.mls_id = {$mls_id} ";
		$sql .= "AND agents.office_id = offices.id AND offices.property_id = properties.id;";
		$result = $this->get_by_sql($sql);
		
	}
	
	public static function get_by_sql($sql="") {
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while ($row = $db->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public function 
}
?>