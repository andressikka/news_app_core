<?php
session_start();
if(isset($_SESSION['username'])){
    header('Location: adminView.php');
}
require_once(dirname(__FILE__)."/DBQueries/DatabaseClass.php");
use admin\DatabaseClass\DatabaseClass as DatabaseClass;
// echo session_id();
$msg = "";
if(isset($_POST['login'])){
    if(isset($_POST["username"]) && isset($_POST["password"])){


        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT id, username, password FROM admin WHERE username=?";
        $db = new DatabaseClass("localhost", "root", "root", "newsapp");
        $bind_params = ["s", $username];
        $result = $db->select($sql, $bind_params);

        if($result == null){
            session_regenerate_id();
            $msg = "You have entered wrong credentials";
        } else if($result[0]["username"] == $username && password_verify($password, $result[0]["password"])){
            session_regenerate_id();
            $_SESSION['username'] = $result[0]['username'];
            $_SESSION['username_id'] = $result[0]['id'];
            session_write_close();
    
            if(!empty($result) && $_SESSION['username'] == $result[0]['username']){
                header('Location: adminView.php');
            }
        }
        
        
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="bg-dark">
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 bg-light mt-5 pb-5 px-0">
                    <h3 class="text-center text-light bg-danger p-3">Admin Loging Form</h3>
                    <form class="p-4" action="<?= $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                        <div class="form-control-lg mb-3">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" autocomplete="off" required/>
                        </div>
                        <div class="form-control-lg mb-4 ">
                            <input type="password" name="password" class="form-control form-control-lg mb-2" placeholder="Password" autocomplete="off" required/>
                            <input type="submit" name="login" class="btn btn-primary" value="Submit"/>
                        </div>
                        
                    </form>
                    <h5 class="text-danger text-center mt-5"><?= $msg; ?></h5>
                </div>
            </div>
    </div>
</body>
</html>

