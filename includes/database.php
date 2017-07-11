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
			die("Database connection failed ".mysqli_connect_error());
		}else{
			$db_select = mysqli_select_db($this->connection,DB_NAME);
			if(!$db_select){
				die("Database selection failed: ".mysqli_connect_error());
			}
		}
	}

	public function close_connection(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function escape_value($value){
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists('mysqli_real_escape_string');

		if($new_enough_php){
			if($magic_quotes_active){$value = stripslashes($value);}
			$value =mysqli_real_escape_string($this->connection,$value);
		}else{
			if(!$magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}

	public function fetch_array($result){
	    return mysqli_fetch_array($result);
    }

	public function query($sql){
		$result = mysqli_query($this->connection,$sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result){
		if(!$result){
			die("Database query failed: ". mysqli_connect_error());
		}
	}

	public function num_rows($result_set){
	    return mysqli_num_rows($result_set);
    }

    public function inserted_id(){
	    //get the last id inserted over the current db connection.
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows(){
        return mysqli_affected_rows($this->connection);
    }


}


$database = new MySQLDatabase();




?>