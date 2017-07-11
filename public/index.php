<html>
    <head>
       <title>Photogallery</title>
        <link rel="stylesheets/main.css" type="text/css" media="all"
    </head>
    <body>
    <?php

    require_once ("../includes/functions.php");
    require_once("../includes/database.php");
    require_once ("../includes/user.php");

//    if(isset($database)){echo "true";}else{echo "false";}
//
//    echo "<br/>";
//
//    $message= "Hello the project's has began<br/>";
//
//    echo $database->escape_value($message);



//   $sql = "INSERT INTO users (id, username, password, first_name, last_name) ";
//   $sql .= "VALUES(4,'mvanda','mvanda2017','Junus','Mvanda') ";
//    $result = $database->query($sql);

//    $sql = "SELECT * FROM users WHERE id =1";
//
//    $result_set = $database->query($sql);
//
//    $found_user = $database->fetch_array($result_set);
//
//    echo $found_user['username'];


    $user = User::find_by_id(1);

//
   echo $user->username."<br/>";

    echo $user->full_name();

   echo "<br/><hr/>";



//    $user_set = User::find_all();
//
//    while($user=$database->fetch_array($user_set)){
////        echo 'Username: '. $user['username']."<br/>";
//
//        echo "Name: ".$user['first_name']. " ".$user['last_name']."<br/>";
//    }


$users = User::find_all();

foreach ($users as $user){
    echo "User: ". $user->username ."<br/>";
    echo "Name: ". $user->full_name() . "<br/><br/>";
}






    ?>

    </body>
</html>

