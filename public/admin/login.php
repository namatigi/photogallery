<?php

require_once ("../../includes/functions.php");
require_once("../../includes/database.php");
require_once ("../../includes/user.php");
require_once ("../../includes/session.php");

date_default_timezone_set('UTC');

if($session->is_logged_in()){
    redirect_to('index.php');
}


//remember to give your form's submit tag a name="submit" attribute

if(isset($_POST['submit'])){


    $username = trim($_POST['username']);
    $password = trim($_POST['password']);




    if($found_user){
        $session->login($found_user);
        redirect_to('index.php');
    }else{
        $message = "Username/password combination incorrect.";
    }
}else{//Form not submitted
    $username = "";
    $password = "";
}

?>
<html>
    <head>
        <title>Login page</title>
        <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css"/>
    </head>
    <body>
    <div id ="header">
        <h1>Photo Gallery</h1>
    </div>
    <div id="main">
        <h2>Staff Login</h2>


        <form action="login.php" method="post">
            <table>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username);?>" />
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" maxlength="40" value="<?php echo htmlentities($password);?>"/>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="submit"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div id="footer">Copyright <?php  echo date("Y",time());?>, Leonard Mangu</div>
    </body>
</html>
<?php if(isset($database)){$database->close_connection();} ?>
