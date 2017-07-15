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


$photos = Photograph::find_all();

date_default_timezone_set('UTC');

if(!$session->is_logged_in()){redirect_to('login.php');}

?>

<?php include_layout_template('admin_header.php');?>


<h2>Photographs</h2>

<table class="boardered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>

  </tr>
  <?php foreach ($photos as $photo): ?>
    <tr>
      <td><img src ="../<?php echo $photo->image_path();?>" widht="100"/></td>
      <td><?php  echo $photo->filename;?></td>
      <td><?php echo $photo->caption;?></td>
      <td><?php echo $photo->size;?></td>
      <td><?php echo $photo->type;?></td>
    </tr>
  <?php endforeach; ?>


</table>
<br/>
<a href="photo_upload.php">Upload a new photograph</a>

<?php include_layout_template('admin_footer.php');?>
