<?php
session_start();
use admin\file_handling\FileOperations as FileOperations;
// echo session_id();
if(!$_SESSION['username']){
    header("Location:login.php");
}
if(!isset($_GET["mark"]) && $_GET["mark"] != "edit"){
    header("Location:../adminView.php");
}
$s = $_SESSION['username_id'];

$date = date('Y-m-d H:i:s');

if(isset($_POST['article_upload'])){
    require_once("../config/config.php");
    
    isset($_POST['title']) ? $title = $_POST['title'] : $title = null;
    isset($_POST['body']) ? $body = $_POST['body'] : $body = null;
    isset($_POST['article_hide']) ? $article_hide = 0 : $article_hide = 1;
    isset($_POST['picture_existance']) ? $picture_existance = 1 : $picture_existance = 0;


    $containment = "upload/";
    $fileName = basename($_FILES['picture']['name']);

    $image_file_type = strtolower($filename,PATHINFO_EXTENSION);
    $allowedTypes = Array("jpg", "png", "jpeg");
    if(in_array($image_file_type, $allowedTypes)){
    }
    
    



}



require_once("./viewparts/head.php");
?>

<body class="bg-light">
    <?php require_once("viewparts/nav.php");?>
    <?php require_once("./viewparts/create_edit.php");?>
</body>
</html>