<?php

/**
 * Created by PhpStorm.
 * User: xnet1872
 * Date: 12/07/2017
 * Time: 08:44
 */
require_once (LIB_PATH.DS.'database.php');

class DatabaseObject{

    protected static $table_name='users';

    public static function find_all(){
        global $database;
//        $result_set = $database->query("SELECT * FROM users");
        return static::find_by_sql("SELECT * FROM ".self::$table_name);

    }

    public static function find_by_id($id=0){
        global $database;
//      $result_set = $database->query("SELECT * FROM users WHERE id={$id}");
        $result_array= static::find_by_sql("SELECT * FROM ".self::$table_name. " WHERE id={$id} LIMIT 1");

        return !empty($result_array)?array_shift($result_array):false;

    }

    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while($row=$database->fetch_array($result_set)){
            $object_array[]=static::instantiate($row);
        }
        return $object_array;
    }

    private static function instantiate($record){
        //simple, long form.
        $class_name = get_called_class();
        $object = new $class_name;
//        $object = new self();
//        $object->id= $record['id'];
//        $object->username=$record['username'];
//        $object->password=$record['password'];
//        $object->first_name=$record['first_name'];
//        $object->last_name=$record['last_name'];
//        return $object;

        foreach ($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute=$value;
            }
        }
        return $object;

    }

    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);

        return array_key_exists($attribute,$object_vars);
    }
}