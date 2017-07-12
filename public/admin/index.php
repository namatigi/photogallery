<?php

//require_once ("../../includes/functions.php");
//require_once("../../includes/database.php");
//require_once ("../../includes/user.php");
//require_once ("../../includes/session.php");

require_once ('../../includes/initialize.php');

date_default_timezone_set('UTC');

if(!$session->is_logged_in()){redirect_to('login.php');}
?>
<?php include_layout_template('admin_header.php');?>

        <h2>Menu</h2>
    </div>

<?php include_layout_template('admin_footer.php');?>



