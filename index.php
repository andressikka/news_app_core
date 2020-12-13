<?php
    if(isset($_GET["cathid"])){
        $cathid = $_GET["cathid"];

        if($cathid == "f"){

        } elseif ($cathid == "s"){

        } elseif ($cathid == "t"){

        }
    }



    require_once("config/config.php");
/**
 * @var mysqli $conn
 */
    $sql = "SELECT id, title, body, picture FROM news ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();



    require_once("user_view/list_elements/head.php");
//    if(!isset($_SESSION['username'])){
        require_once("user_view/navbar/nav.php");

//    }

?>

<body class="bg-light">
<!-- Hot news-->



<!-- All other news -->
    <div class="container pt-5">
        <div class="row row-cols-4 ">
    <?php 
        while($row = $result->fetch_assoc()){ ?>
            <div class="column bg-light">
                <!-- A picture can be placed here -->
                <?php if(isset($_SESSION["username"])){ ?>
                    <img src="upload/<?= $row["id"] ?>/<?= $row["picture"] ?>" width="286" height="180" alt="<?= $row["picture"] ?>"/>
                    <a href="../user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                <?php } else { ?>
                <img src="admin/upload/<?= $row["id"] ?>/<?= $row["picture"] ?>" width="286" height="180" alt="<?= $row["picture"] ?>"/>
                <a href="user_article.php?id=<?= $row['id'] ?>"><h4 class="card-title"><?= $row["title"] ?></h4></a>
                <?php } ?>

                <p class="card-text"></p>
            </div>
   <?php } ?>
        </div>
    </div>
</body>
</html>