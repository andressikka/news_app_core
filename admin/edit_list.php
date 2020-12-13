<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}

require_once("../config/config.php");
/**
 * @var mysqli $conn
 */
if(isset($_POST["delete_article"])){
    $sql = "DELETE FROM news WHERE id=?";
    $stmt = $conn->prepare($sql);
    $id = $_POST["id"];
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $files = glob("upload/" . $id . "/*");
    foreach($files as $file){
        if(is_file($file)){
            unlink($file);
        }
    }
    rmdir("upload/" . $id);

}

$sql = "SELECT id, title, body, article_visibility, picture_visibility FROM news ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>


<?php require_once("./viewparts/head.php"); ?>
<body class="bg-light">
<?php require_once("viewparts/nav.php");?>
<div class="container pt-5">
    <?php while($row = $result->fetch_assoc()){ ?>
        <div class="row justify-content-center">
            <div class="col-10 list-group-item"><h4><?= $row['title'] ?></h4></div>
            <div class="col-1 list-group-item">
                <form action="edit.php?mark=edit&id=<?= $row['id'] ?>" method="POST">
                    <!-- <input type="hidden" name="mark" value="edit"> -->
                    <input type="hidden" name="title" value="<?= $row['title'] ?>">
                    <input type="hidden" name="body" value="<?= $row['body'] ?>">
                    <input type="hidden" name="article_visibility" value="<?= $row['article_visibility'] ?>">
                    <input type="hidden" name="picture_visibility" value="<?= $row['picture_visibility'] ?>">
                    <input class="btn btn-primary" type="submit" value="Edit">

                </form>
                <!-- <a class="btn btn-primary" href="edit.php?mark=edit&id=<?= $row['id'] ?>">Edit</a> -->
            </div>
            <div class="col-1 list-group-item">
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input class="btn btn-danger p-1" type="submit" name="delete_article" value="Delete">
                </form>
            </div>
        </div>
    <?php } $conn->close();?>
</div>