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

$max_file_size = 1048576;

$message = "";
if(isset($_POST['submit'])){
  $photo = new Photograph();

  $photo->caption = $_POST['caption'];

  $photo->attach_file($_FILES['file_upload']);;

  if($photo->save()){
    $message = "Photograph uploaded successfully";
  }else{
    $message = join("<br/>",$photo->errors);
  }
}

date_default_timezone_set('UTC');

if(!$session->is_logged_in()){redirect_to('login.php');}

?>

<?php include_layout_template('admin_header.php');?>

<h2>Photo upload</h2>

<?php echo output_message($message); ?>
<form action='photoupload.php' enctype="multipart/form-data" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>"/>
  <p><input type="file" name="file_upload" /></p>
  <p>Caption: <input type="text" name="caption" value=""/></p>
  <input type="submit" name="submit" value="Upload" />
</form>

<?php include_layout_template('admin_footer.php');?>
