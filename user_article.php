<?php
session_start();
require_once(__DIR__."/admin/DBQueries/DatabaseClass.php");
use admin\DatabaseClass\DatabaseClass as DatabaseClass;
    
    
require_once("user_view/list_elements/head.php");
if(isset($_SESSION["username"])){ ?>
    <div class="container">
    <div class="row border">
        <div class="col-md-2 p-2"><a href="admin/adminView.php">Overview</a></div>
        <div class="col-md-2 p-2"><a href="admin/create.php?mark=create">Create</a></div>
        <div class="col-md-6 p-2"><a href="admin/edit_list.php">Artilces</a></div>
        <a href="admin/logout.php" class="col-md-2 pt-2">Logout</a>
    </div>
</div>
<?php }
require_once("user_view/navbar/nav.php");

if(isset($_GET["id"])){
    $article_id = $_GET["id"];
} else {
    header("Location: index.php"); return;
}

$db = new DatabaseClass("localhost", "root", "root", "newsapp");
$sql = "SELECT id, title, body, article_visibility FROM news WHERE id=?";
$result = $db->select($sql, ["i", $article_id]);



?>

<body class="bg-light">
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="media justify-content-center">
                <div class="media-body justify-content-center">
                    <h3 class="mt-0"><?= $result[0]["title"] ?></h3>
                    <img class="card-img-top" style="padding-bottom: 23px;" src="">
                    <p><?= $result[0]["body"] ?></p>

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
