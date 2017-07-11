<html>
    <head>
       <title>Photogallery</title>
    </head>
    <body>
    <?php

    require_once("../includes/database.php");

    if(isset($database)){echo "true";}else{echo "false";}

    echo "<br/>";

    $message= "Hello the project's has began<br/>";

    echo $database->mysql_prep($message);



    $sql = "INSERT INTO users (id, username, password, first_name, last_name) ";
    $sql .= "VALUES(4,'mvanda','mvanda2017','Junus','Mvanda') ";
    $result = $database->query($sql);





    ?>

    </body>
</html>

