<?php
    require_once(__DIR__."/admin/DBQueries/DatabaseClass.php");
    use admin\DatabaseClass\DatabaseClass as DatabaseClass;
    
    $db = new DatabaseClass("localhost", "root", "root", "newsapp");
    
    if(isset($_GET["cathid"])){
        $sql = "SELECT id, title, body, picture, article_visibility, picture_visibility FROM news WHERE categoryId = ? ORDER BY id DESC";
        $cathid = $_GET["cathid"];
        if($cathid == "economy"){
            $result = $db->select($sql, ["i", 2]);
        } elseif ($cathid == "politics"){
            $result = $db->select($sql, ["i", 3]);
        } elseif ($cathid == "history"){
            $result = $db->select($sql, ["i", 4]);
        }
    } else if(!isset($_GET["cathid"])){
        $sql = "SELECT id, title, body, picture, article_visibility, picture_visibility FROM news ORDER BY id DESC";
        $result = $db->select($sql);
    }



    require_once(__DIR__."/user_view/list_elements/head.php");
    require_once(__DIR__."/user_view/navbar/nav.php");


?>

<body class="bg-light">
<!-- Hot news-->



<!-- All other news -->

    <div class="container">
        <div class="row row-cols-4">
    <?php 
        foreach($result as $row){ 
            if($row["article_visibility"] == false){
                continue;
            } ?>
            
            <div class="column bg-light">
                <div class="card-border-0 p-1" style="width: 18em;">
                    <!-- A picture can be placed here -->
                    <?php if($row["picture_visibility"] == 0){?>
                        <?php if(isset($_SESSION["username"])){ ?>
                        <a href="../user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                        <p class="card-text"><?= substr($row["body"], 0, 150) . "..." ?></p>
                        <?php } else { ?>
                        <a href="user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                        <p class="card-text"><?= substr($row["body"], 0, 150) . "..." ?></p>
                        <?php } ?>

                    <?php } else {?>

                    <?php if(isset($_SESSION["username"])){ ?>
                        <img class="card-img-top" src="upload/<?= $row["id"] ?>/<?= $row["picture"] ?>" width="286" height="180" alt="<?= $row["picture"] ?>"/>
                        <a href="../user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                        <p class="card-text"><?= substr($row["body"], 0, 150) . "..."?></p>
                    <?php } else { ?>
                    <img class="card-img-top" src="admin/upload/<?= $row["id"] ?>/<?= $row["picture"] ?>" width="286" height="180" alt="<?= $row["picture"] ?>"/>
                    <a href="user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                    <p class="card-text"><?= substr($row["body"], 0, 150) . "..." ?></p>
                    <?php } ?>

                    <p class="card-text"></p>
                </div>
            </div>
   <?php }  } ?>
        </div>
    </div>
</body>
</html>