<?php

require_once ("../../includes/functions.php");
require_once("../../includes/database.php");
require_once ("../../includes/user.php");
require_once ("../../includes/session.php");

date_default_timezone_set('UTC');

if(!$session->is_logged_in()){redirect_to('login.php');}
?>

<html>
    <head>
       <title>Photogallery</title>
        <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css"/>
    </head>
    <body>
    <div id="header">
        <h1>Photo Gallery</h1>
    </div>

    <div id="main">
        <h2>Menu</h2>
    </div>




    <div id="footer">Copyright <?php  echo date("Y",time());?>,Leonard Mangu</div>

    </body>
</html>

