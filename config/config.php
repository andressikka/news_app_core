<?php
// if(!isset($_SESSION['username'])){
//     header("Location: ../admin/login.php");
// }

    $host = "localhost";
    $username="root";
    $password="";
    $db = "newsapp";

    $conn = new mysqli($host, $username, $password, $db);

    if($conn->connect_error){
        die ("Connection failed: " . $conn->connect_error);
    }
?>