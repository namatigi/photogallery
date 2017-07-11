<html>
    <head>
       <title>Photogallery</title>
    </head>
    <body>
    <?php

    require_once("../includes/database.php");

    if(isset($database)){echo "true";}else{echo "false";}

    echo "<br/>";

    $message= "Hello the project's has began";

    echo $database->mysql_prep($message);

    ?>

    </body>
</html>

