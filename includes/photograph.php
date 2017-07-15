<?php
require_once(LIB_PATH.DS.'database.php');
// require_once(LIB_PATH.DS.'database_object.php');

class Photograph extends DatabaseObject{

  protected static $table_name="photographs";
  protected static $db_fields = array('filename','type','size','caption');

  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;

  private $temp_path;
  protected $upload_dir = "images";

  public $errors = array();

  protected $upload_errors = array(

       UPLOAD_ERR_OK =>"No errors",
       UPLOAD_ERR_INI_SIZE =>"Larger than upload_max_filesize.",
       UPLOAD_ERR_FORM_SIZE =>"Larger than form MAX_FILE_SIZE",
       UPLOAD_ERR_PARTIAL =>"Partial upload",
       UPLOAD_ERR_NO_FILE =>"No file.",
       UPLOAD_ERR_NO_TMP_DIR =>"No temporary directory.",
       UPLOAD_ERR_CANT_WRITE =>"Can't write to disk.",
       UPLOAD_ERR_EXTENSION =>"File upload stopped by extension."
     );


  public function attach_file($file){

      if(!$file || empty($file) || !is_array($file)){
        $this->errors[]="No file was uploaded.";
        return false;
      }elseif($file['error']!=0){
        $this->error[]=$this->upload_errors[$file['error']];
        return false;
      }else{
        $this->temp_path = $file['tmp_name'];
        $this->filename = basename($file['name']);
        $this->type = $file['type'];
        $this->size = $file['size'];

        return true;
      }

    }

  public function save(){
      //A new record won't have an id yet.
      if(isset($this->id)){
        //Just to update the caption.
        $this->update1();
      }else{
        //make sure there are no erros.
        //Can't save if there are pre_existing errors.
        if(!empty($this->errors)){return false;}

        //make sure the caption is not long for the DB.
        if(strlen($this->caption)>=255){
          $this->errors[] = "The caption can only be 255 characters long";
          return false;
        }
        //make sure the filename and temp_dir are set.
        if(empty($this->filename)||empty($this->temp_path)){
          $this->errors[] = 'The file location was not available';
          return false;
        }

        $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;

        if(file_exists($target_path)){
          $this->errors[] = "The file {$this->filename} alread exists.";
          return false;
        }

        if(move_uploaded_file($this->temp_path,$target_path)){
          if($this->create1()){
              unset($this->temp_path);
              return true;
          }
        }else{
          //File was not moved..
          $this->errors[] = "The file upload failed, possibly due to incorrect permission on the upload folder";
          return false;
        }


      }
    }

  public function image_path(){
    return $this->upload_dir.DS.$this->filename;
  }

  public static function find_all(){
      global $database;
      //        $result_set = $database->query("SELECT * FROM users");
      return self::find_by_sql("SELECT * FROM ".self::$table_name);

  }

  public static function find_by_id($id=0){
      global $database;
      //      $result_set = $database->query("SELECT * FROM users WHERE id={$id}");
      $result_array= self::find_by_sql("SELECT * FROM ".self::$table_name. " WHERE id={$id} LIMIT 1");

      return !empty($result_array)?array_shift($result_array):false;

  }

  public static function find_by_sql($sql=""){
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while($row=$database->fetch_array($result_set)){
          $object_array[]=self::instantiate($row);
      }
      return $object_array;
  }

  private static function instantiate($record){
      //simple, long form.
      // $class_name = get_called_class();
      $object = new self();
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

  protected function attributes(){
    //        return get_object_vars($this);

      $attributes =array();
      foreach (self::$db_fields as $field){
          if(property_exists($this,$field)){
              $attributes[$field]=$this->$field;
          }
      }
      return $attributes;
  }

  private function has_attribute($attribute){
    //        $object_vars = get_object_vars($this);

        $object_vars = $this->attributes();

      return array_key_exists($attribute,$object_vars);
  }

  protected function sanitized_attributes(){
      global $database;

      $clean_attributes = array();

      foreach ($this->attributes() as $key => $value){
          $clean_attributes[$key]=$database->escape_value($value);
      }

      return $clean_attributes;
  }


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


  public function create(){
      global $database;

      $sql = "INSERT INTO" .self::$table_name."(";
      $sql .="username,password,first_name,last_name ";
      $sql .=") VALUES( '";
      $sql .=$database->escape_value($this->username)."', '";
      $sql .=$database->escape_value($this->password)."' ,'";
      $sql .=$database->escape_value($this->first_name)."', '";
      $sql .=$database->escape_value($this->last_name). "')";

      if($database->query($sql)){
          $this->id = $database->inserted_id();
          return true;
      }else{
          return false;
      }
  }

  public function update(){
      global $database;

      $sql = "UPDATE ".self::$table_name." SET ";
      $sql .="username='".$database->escape_value($this->username)."', ";
      $sql .="password='".$database->escape_value($this->password)."', ";
      $sql .="first_name='".$database->escape_value($this->first_name)."', ";
      $sql .="last_name='".$database->escape_value($this->last_name)."'";
      $sql .=" WHERE id =".$database->escape_value($this->id);

      $database->query($sql);
      return ($database->affected_rows()==1)?true:false;
  }

  public function delete(){
      global $database;

      $sql ="DELETE FROM ".self::$table_name." ";
      $sql .="WHERE id= ".$database->escape_value($this->id);
      $sql .= " LIMIT 1";
      $database->query($sql);
      return ($database->affected_rows()==1)? true:false;
  }

  public function create1(){
      global $database;

      $attributes = $this->sanitized_attributes();

      $sql = "INSERT INTO ".self::$table_name. " (";
      $sql .=join(", ",array_keys($attributes));
      $sql .=") VALUES ('";
      $sql .=join("' , '",array_values($attributes));
      $sql .="')";
      if($database->query($sql)){
          $this->id=$database->inserted_id();
          return true;
      }else{
          return false;
      }


  }

  public function update1(){
      global $database;
      $attributes =$this->sanitized_attributes();
      $attribute_pairs = array();
      foreach ($attributes as $key=>$value){
          $attribute_pairs[] = "{$key} = '{$value}'";
      }

      $sql = "UPDATE ".self::$table_name. " SET ";
      $sql .=join(", ",$attribute_pairs);
      $sql .=" WHERE id=".$database->escape_value($this->id);
      $database->query($sql);
      return($database->affected_rows()==1)? true:false;
  }

}


 ?>
