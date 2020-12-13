<?php 
if(!isset($_SESSION['username'])){
    header("Location: ../login.php");
}

require_once(dirname(__FILE__)."/../../config/config.php");
/**
 * @var mysqli $conn
 */
if(isset($_GET["id"])){
    $sql = "SELECT news.title, news.body, news.article_visibility, news.picture_visibility, category.category 
        FROM news INNER JOIN category ON news.categoryId=category.id 
        WHERE news.id=?";
    $stmt = $conn->prepare($sql);
    $id = (int)$_GET["id"];
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}



?>
<div class="container pt-5">
        <div class="row justify-content-center">
        <?php if(isset($_GET["mark"]) && $_GET["mark"] == "create"){ ?>
            <form action="create.php?mark=create" method="post" enctype="multipart/form-data">
        <?php } else if(isset($_GET["mark"]) && $_GET["mark"] == "edit"){ ?>
            <form action="edit.php?mark=edit&id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
        <?php }?>
                <div class="form-group">
                <?php

                
                if(isset($_GET["mark"]) && $_GET["mark"] == "create"){ ?>
                    <input autocomplete="off" class="form-control" type="text" name="title" placeholder="Article's Title"/><br>
                    <textarea style="resize: none;" class="form-control" rows="10" cols="100" name="body"></textarea><br>
                <?php }


                else if(isset($_GET["mark"]) && $_GET["mark"] == "edit"){ 
                    if(!isset($row["title"]) && !isset($row["body"])){
                        header("Location:edit_list.php");
                    }
                    ?>
                    <input autocomplete="off" class="form-control" type="text" name="title" value="<?= $row["title"] ?>"/><br>
                    <textarea style="resize: none;" class="form-control" rows="10" cols="100" name="body"><?= $row["body"] ?></textarea><br>
                    <input type="hidden" name="ArticleId" value="<?= $_GET["id"] ?>">
                <?php } ?>
                    <input class="btn btn-primary" name="article_upload" type="submit" value="Post the article">

                    <input class="btn btn-primary" name="picture" type="file">
                    <?php 
                    if(isset($_GET["mark"]) && $_GET["mark"] == "create"){ ?>
                        <input type="checkbox" name="article_hide"> Hide Article &nbsp;
                        <?php
                    }
                    if(isset($_GET["mark"]) && $_GET["mark"] == "edit"){
                        if(isset($row["picture_visibility"])){
                            if($row["picture_visibility"] == 0){
                                ?> <input type="checkbox" name="picture_existance"> Picture Existance
                                <?php
                            } else if ($row["picture_visibility"] == 1){
                                ?> <input type="checkbox" name="picture_existance" checked> Picture Existance
                                <?php
                            }
                        }

                        if(isset($row["article_visibility"])){
                            if($row["article_visibility"] == 0){
                                ?> <input type="checkbox" name="article_hide" checked> Hide Article
                                <?php
                            } else if ($row["article_visibility"] == 1){
                                ?> <input type="checkbox" name="article_hide"> Hide Article
                                <?php
                            }
                        }
                     } ?>
                    Select a category:
                    <select name="categories">
                            <?php
                            $sql = "SELECT id, category FROM category";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();


                            ?>
                            <option name="noCategory">...</option>
                            <?php
                                while($row = $result->fetch_assoc()){ ?>
                                    <option name="<?=$row["category"] ?>" value="<?=$row["id"] ?>"><?=$row["category"] ?></option>
                                <?php };
                            ?>



                        ?>

                    </select>
                    
                </div>
            </form>
        </div>
    </div>