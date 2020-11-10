<?php 
session_start();
use admin\file_handling\FileOperations as FileOperations;

include_once("file_handling/FileOperations.php");
// echo session_id();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
if(!isset($_GET["mark"]) && $_GET["mark"] != "create"){
    header("Location:../adminView.php");
}


$s = $_SESSION['username_id'];

$date = date('Y-m-d H:i:s');





if(isset($_POST['article_upload'])){
    require_once("../config/config.php");

    isset($_POST['title']) ? $title = $_POST['title'] : $title = null;
    isset($_POST['body']) ? $body = $_POST['body'] : $body = null;
    isset($_POST['article_hide']) ? $article_hide = 0 : $article_hide = 1;

    if(!empty($_FILES["picture"]["name"])){
        $FileOperations = new FileOperations("upload/",$_FILES["picture"], Array("jpg", "jpeg", "png"));
        $containment = "upload/";
        $fileName = $FileOperations->getFileName();
        $image_file_type = $FileOperations->imageFileType();
        $allowedTypes = $FileOperations->getAllowedTypesOfPictures();
    
        if(in_array($image_file_type, $allowedTypes)){
            $sql = "INSERT INTO news (title, body, created_at, article_visibility, picture, picture_visibility, adminId) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssisii", $title, $body, $date, $article_hide, $fileName, $picture_existance, $s);
            $stmt->execute();
            $last_id = mysqli_insert_id($conn);
            mkdir("upload/" . $last_id);
            $conn->close();
    
            $FileOperations->savePicture($last_id);
        }
    } else {
        $sql = "INSERT INTO news (title, body, created_at, article_visibility, picture, adminId) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssisi", $title, $body, $date, $article_hide, $fileName, $s);
            $stmt->execute();
            $last_id = mysqli_insert_id($conn);
            mkdir("upload/" . $last_id);
            $conn->close();
    }
    
    




}

require_once("./viewparts/head.php");
?>

<body class="bg-light">
    <?php require_once("viewparts/nav.php");?>
    <?php require_once("./viewparts/create_edit.php");?>

</body>
</html>
