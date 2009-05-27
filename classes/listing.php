<?php
abstract class Listing {
	
	public $id;
	public $property_id;
	public $mls_id;
	public $agent_id;
	public $broker_id;
	public $price;
	public $orig_price;
	public $agent_remarks;
	
	private $table_name;
	
	abstract private function instantiate($record);
	
	abstract public function insert($record);
}
?>