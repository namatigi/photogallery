<?php
/**
 * Created by PhpStorm.
 * User: xnet1872
 * Date: 11/07/2017
 * Time: 19:50
 */

class Session{

    private $logged_in=false;
    public $user_id;
    public $message;

    function __construct(){
        session_start();
        $this->check_message();
        $this->check_login();
    }

    public function is_logged_in(){
        return $this->logged_in;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id']=$user->id;
            $this->logged_in=true;
        }
    }

    public function  logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in=false;
    }

    public function message($msg=""){
      if(!empty($msg)){
        //then this is the "set message"
        $_SESSION['message']=$msg;
      }else{
        //get this is 'get message'.
        return $this->message;
      }
    }

    private function check_login(){
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        }else{
            unset($this->user_id);
            $this->logged_in=false;
        }
    }

    private function check_message(){
      //is there a message stored in the session.
      if(isset($_SESSION['message'])){
        $this->message = $_SESSION['message'];
        unset($_SESSION['message']);
      }else{
        $this->message = "";
      }
    }

}


$session = new Session();
