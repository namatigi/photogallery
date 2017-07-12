<?php
/**
 * Created by PhpStorm.
 * User: xnet1872
 * Date: 11/07/2017
 * Time: 18:29
 */
//require_once ('functions.php');
require_once (LIB_PATH.DS.'database.php');
require_once (LIB_PATH.DS.'database_object.php');


class User extends DatabaseObject {

    protected static $table_name='users';
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;



    public static function authenticate($username="",$password=""){
        global $database;

        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "SELECT * FROM users ";
        $sql .="WHERE username = '{$username}' ";
        $sql .="AND password ='{$password}' ";
        $sql .="LIMIT 1";

        $result_array = self::find_by_sql($sql);

        return !empty($result_array)?array_shift($result_array):false;
    }

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return strtoupper($this->first_name . " " . $this->last_name)."<br/>";
        }else{
            return "";
        }
    }




}