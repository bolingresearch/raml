<?php
//require_once(ABSPATH . "raml-config.php");

class MySQLiDatabase {
	
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	public $last_query;
	
	public function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
	}
	
	public function __destruct() {
		$this->close_connection();
	}
	
	private function open_connection() {
		$this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysqli_error($this->connection));
		} else {
			$db_select = mysqli_select_db($this->connection, DB_NAME);
			if (!$db_select) {
				die ("Database selection failed: " . mysqli_error($this->connection));
			}
			echo "DB connected.<br />";
		}
	}
	
	public function close_connection() {
		if (isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
			echo "DB connection closed.<br />";
		}
	}
	
	public function query($sql) {
		// save this query for future reference
		$this->last_query = $sql;
		
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}
	
	private function confirm_query($result) {
		if (!$result) {
			$output  = "Database query failed: " . mysqli_error($this->connection) . "<br />";
			$output .= "Last SQL query: " . $this->last_query;
			die($output);
		}
	}
	
	public function escape($value) {
		
		if ($this->real_escape_string_exists) { // PHP v4.3.0 or higher
			// undo any magic quote effects
			if ($this->magic_quotes_active) { $value = stripslashes($value); }
			$value = mysqli_real_escape_string($this->connection, $value);
		} else { // before PHP v4.3.0
			// if magic quotes aren't on, then add slashes manually
			if (!$this->magic_quotes_active) { $value = addslashes($value); }
		}
		return $value;
	}
	
	// "database-neutral" methods
	public function fetch_array($result) {
		return mysqli_fetch_array($result);
	}
	
	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}
	
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->connection);
	}
	
	public function affected_rows() {
		return mysqli_affected_rows($this->connection);
	}
}

$db = new MySQLiDatabase();
?>