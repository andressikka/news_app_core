<?php
session_start();
if(isset($_SESSION['username'])){
    header('Location: adminView.php');
}
// echo session_id();
$msg = "";
if(isset($_POST['login'])){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        require_once("../config/config.php");
        /**
         * @var mysqli $conn
         */

        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT id, username, password FROM admin WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $conn->close();
        // echo var_dump($row);




        if($row == null){
            session_regenerate_id();
            $msg = "You have entered wrong credentials";
//             header("Location: login.php");
        } else if($row["username"] == $username && password_verify($password, $row["password"])){
            session_regenerate_id();
            $_SESSION['username'] = $row['username'];
            $_SESSION['username_id'] = $row['id'];
            session_write_close();
    
            if($result->num_rows == 1 && $_SESSION['username'] == $row['username']){
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

