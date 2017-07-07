<?php
require_once("config.php");


class MySQLDatabase{

	private $connection;

	function __construct(){
		$this->open_connection();
	}

	public function open_connection(){
		$this ->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		if(!$this->connection){
			die("Database connection failed ".mysqli_error());
		}else{
			$db_select = mysqli_select_db($this->connection,DB_NAME);
			if(!$db_select){
				die("Database selection failed: ".mysqli_error());
			}
		}
	}

	public function close_connection(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function mysql_prep($value){
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists('mysqli_real_escape_string');

		if($new_enough_php){
			if($magic_quotes_active){$value = stripslashes($value);}
			$value =mysqli_real_escape_string($value);
		}else{
			if(!$magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}

	public function query($sql){
		$result = mysqli_query($this->connection,$sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result){
		if(!$result){
			die("Database query failed: ".mysqli_error());
		}
	}


}


$database = new MySQLDatabase();




?>