<?php
    use admin\DatabaseClass\DatabaseClass as DatabaseClass;
    
    if(isset($_POST["aLogin"])){
        $aLogin = $_POST["aLogin"];
    }
    if(isset($_POST["aPassword1"])){
        $aPassword1 = password_hash($_POST["aPassword1"], PASSWORD_DEFAULT);
    }
    if(isset($_POST["aPassword2"])){
        $aPassword2 = $_POST["aPassword2"];
    }
//    if($aPassword1 == $aPassword2){
//        return $aPassword1;
//    } else {
//        header("Location:registration.php");
//    }

    if(isset($_POST["submitF"])){
        require_once(dirname(__FILE__)."/DBQueries/DatabaseClass.php");

        $sql = "INSERT INTO admin (username, password) VALUES (?,?)";
        $db = new DatabaseClass("localhost", "root", "root", "newsapp");
        $bind_params = ["ss", $aLogin, $aPassword1];
        $db->insert($sql,$bind_params);


    }




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin registration</title>
</head>
<body>
    <form action="registration.php" method="post">
        <input type="text" name="aLogin" autocomplete="off" required/> <br>
        <input type="password" name="aPassword1" autocomplete="off" required/> <br>
<!--        <input type="password" name="aPassword2"/> <br>-->
        <input type="submit" name="submitF" value="Register">
    </form>
</body>
</html>