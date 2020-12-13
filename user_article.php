<?php
session_start();
require_once("user_view/list_elements/head.php");
if(isset($_SESSION["username"])){
    require_once("./admin/viewparts/nav.php");
}

if(isset($_GET["id"])){
    $article_id = $_GET["id"];
} else {
    header("Location: index.php"); return;
}

require_once("config/config.php");
/**
 * @var mysqli $conn
 */

$sql = "SELECT id, title, body, article_visibility FROM news WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $article_id);
$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();


?>

<body class="bg-light">
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="media justify-content-center">
                <div class="media-body justify-content-center">
                    <h3 class="mt-0"><?= $row["title"] ?></h3>
                    <img class="card-img-top" style="padding-bottom: 23px;" src="">
                    <p><?= $row["body"] ?></p>

                    <a class="btn btn-primary" href="">Leave comment</a>
                    <?php
                        if(isset($_SESSION["username"])){
                            ?> <a class="btn btn-danger" href="./admin/adminView.php">Back</a>
                        <?php } else { ?>
                            <a class="btn btn-danger" href="index.php">Back</a>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

</body>
