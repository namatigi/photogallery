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

    echo $database->escape_value($message);



//    $sql = "INSERT INTO users (id, username, password, first_name, last_name) ";
//    $sql .= "VALUES(4,'mvanda','mvanda2017','Junus','Mvanda') ";
//    $result = $database->query($sql);

    $sql = "SELECT * FROM users WHERE id =1";

    $result_set = $database->query($sql);

    $found_user = $database->fetch_array($result_set);

    echo $found_user['username'];





    ?>

    </body>
</html>

