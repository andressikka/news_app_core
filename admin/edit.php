<?php
session_start();
use admin\file_handling\FileOperations\FileOperations as FileOperations;
// echo session_id();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
if(!isset($_GET["mark"]) && $_GET["mark"] != "edit"){
    header("Location:../adminView.php");
}
$s = $_SESSION['username_id'];

$date = date('Y-m-d H:i:s');

if(isset($_POST['article_upload'])){
    include_once("../config/config.php");
    /**
     * @var mysqli $conn
     */

    isset($_POST['title']) ? $title = $_POST['title'] : $title = null;
    isset($_POST['body']) ? $body = $_POST['body'] : $body = null;
    isset($_POST['article_hide']) ? $article_hide = 0 : $article_hide = 1;
    isset($_POST['picture_existance']) ? $picture_existance = 1 : $picture_existance = 0;



    if(!empty($_FILES["picture"]["name"])){
        // I have no idea why it is not working with importing namespace :(
        // $FileOperations = new FileOperations("upload/",$_FILES["picture"], Array("jpg", "jpeg", "png"));
        
        include_once("./file_handling/FileOperations.php");
        $FileOperations = new FileOperations("upload/",$_FILES["picture"], Array("jpg", "jpeg", "png"));
        $containment = "upload/";
        $fileName = $FileOperations->getFileName();
        $image_file_type = $FileOperations->imageFileType();
        $allowedTypes = $FileOperations->getAllowedTypesOfPictures();
    
        if(in_array($image_file_type, $allowedTypes)){
            $sql = "UPDATE news SET title=?, body=?, updated_at=?, article_visibility=?, picture=?, picture_visibility=?, last_adminId=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $articleId = (int)$_POST["ArticleId"];
            $stmt->bind_param("sssisiii", $title, $body, $date, $article_hide, $fileName, $picture_existance, $s, $articleId);
            $stmt->execute();
            $conn->close();
    
            $FileOperations->savePicture($articleId);
        }
    } else {
        $sql = "UPDATE news SET title=?, body=?, updated_at=?, article_visibility=?, last_adminId=?, picture_visibility=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $articleId = (int)$_POST["ArticleId"];
        $stmt->bind_param("sssiisi", $title, $body, $date, $article_hide, $s, $picture_existance, $articleId);
        $stmt->execute();
        $conn->close();
    }

    



    
}



include_once("./viewparts/head.php");
?>

<body class="bg-light">
    <?php include_once("viewparts/nav.php");?>
    <?php include_once("./viewparts/create_edit.php");?>
</body>
</html>