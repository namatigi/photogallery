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

        <h2>Menu</h2>
            <a href="logfile.php">Clear log files</a><br/><br/>

            <a href="index.php?logout=true">Logout</a><br/>

    </div>

<?php include_layout_template('admin_footer.php');?>



