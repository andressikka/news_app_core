<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}

require_once(dirname(__FILE__)."/DBQueries/DatabaseClass.php");
use admin\DatabaseClass\DatabaseClass as DatabaseClass;

if(isset($_POST["delete_article"])){
    $sql = "DELETE FROM news WHERE id=?";
    $db = new DatabaseClass("localhost", "root", "root", "newsapp");
    $id = $_POST["id"];
    $db->remove($sql, ["i", $id]);

    $files = glob("upload/" . $id . "/*");
    foreach($files as $file){
        if(is_file($file)){
            unlink($file);
        }
    }
    rmdir("upload/" . $id);

}

$filterArray = [];
isset($_POST["cbPolitics"]) && $_POST["cbPolitics"] == "on" ? $filterArray["cbPolitics"] = true : $filterArray["cbPolitics"] = false;
isset($_POST["cbEconomy"]) && $_POST["cbEconomy"] == "on" ? $filterArray["cbEconomy"] = true : $filterArray["cbEconomy"] = false;
isset($_POST["cbHistory"]) && $_POST["cbHistory"] == "on" ? $filterArray["cbHistory"] = true : $filterArray["cbHistory"] = false;

isset($_POST["ascDesc"]) && $_POST["ascDesc"] != "..." ? $filterArray["ascDesc"] = $_POST["ascDesc"] : $filterArray["ascDesc"] = false;



$db = new DatabaseClass("localhost", "root", "root", "newsapp");
$sql = "SELECT id, title, body, article_visibility, picture_visibility FROM news ORDER BY id DESC";
$result = $db->select($sql);

?>


<?php require_once("./viewparts/head.php"); ?>
<body class="bg-light">
<?php require_once("viewparts/nav.php");?>


<div class="container-fluid pt-5">
    <div class="row p-3"> 
        <form action="" class="col-2" method="POST">
            <b>Categories:</b>
            <input type="checkbox" name="cbPolitics"/> Politics &nbsp;
            <input type="checkbox" name="cbEconomy"/> Economy &nbsp;
            <input type="checkbox" name="cbHistory"/> History &nbsp;
            <br>
            
            <b>Choose position:</b>
            <select name="ascDesc">
                <option name="ddlNone">...</option>
                <option name="ddlAscending">Ascending</option>
                <option name="ddlDescending">Descending</option>

            </select>
            <br>
            <input type="submit" class="btn btn-primary" value="Filter">
        </form>
        <div class="col-9">
            <?php foreach($result as $row){ ?>
                <div class="row ">
                    <div class="col-10 list-group-item"><h4><?= $row['title'] ?></h4></div>
                    <div class="col-1 list-group-item">
                        <form action="edit.php?mark=edit&id=<?= $row['id'] ?>" method="POST">
                            <input class="btn btn-primary" type="submit" value="Edit">

                        </form>
                    </div>
                    <div class="col-1 list-group-item">
                        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input class="btn btn-danger p-1" type="submit" name="delete_article" value="Delete">
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
    
</div>