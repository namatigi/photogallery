<?php

//require_once ("../../includes/functions.php");
//require_once("../../includes/database.php");
//require_once ("../../includes/user.php");
//require_once ("../../includes/session.php");

require_once ('../../includes/initialize.php');

if(isset($_GET['logout']) && $_GET['logout']==true){
    $session->logout();
    redirect_to('login.php');
}

date_default_timezone_set('UTC');

if(!$session->is_logged_in()){redirect_to('login.php');}
?>

<?php include_layout_template('admin_header.php');?>
<?php
//    $user = new User();
//    $user->username="Solomoni";
//    $user->password="12345";
//    $user->first_name="Solo";
//    $user->last_name="Mangu";
//    $user->create();

//$user = User::find_by_id(9);
//
//$user->password ="12345ABCD";
//
//$user ->save();

$user = User::find_by_id(12);

$user->delete();

echo $user->full_name();


?>
<?php include_layout_template('admin_footer.php');?>



