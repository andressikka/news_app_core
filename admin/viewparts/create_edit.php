<?php 
if(!isset($_SESSION['username'])){
    header("Location: ../login.php");
}



require_once(dirname(__FILE__)."/../DBQueries/DatabaseClass.php");

use admin\DatabaseClass\DatabaseClass as DatabaseClass;

/**
 * @var mysqli $conn
 */
if(isset($_GET["id"])){
    $sql = "SELECT news.title, news.body, news.article_visibility, news.picture_visibility, news.categoryId, category.category
        FROM news INNER JOIN category ON news.categoryId=category.id 
        WHERE news.id=?";
    $id = (int)$_GET["id"];
    $bind_params = Array("i", $id);
    $db = new DatabaseClass("localhost", "root", "root", "newsapp");
    $result = $db->select($sql, $bind_params);
    $resultCategoryId = [];
    array_push($resultCategoryId, $result[0]["categoryId"]);
    
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
                if(!isset($result[0]["title"]) && !isset($result[0]["body"])){
                    header("Location:edit_list.php");
                }
                ?>
                <input autocomplete="off" class="form-control" type="text" name="title" value="<?= $result[0]["title"] ?>"/><br>
                <textarea style="resize: none;" class="form-control" rows="10" cols="100" name="body"><?= $result[0]["body"] ?></textarea><br>
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
                    if(isset($result[0]["picture_visibility"])){
                        if($result[0]["picture_visibility"] == 0){
                            ?> <input type="checkbox" name="picture_existance"> Picture Existance
                            <?php
                        } else if ($result[0]["picture_visibility"] == 1){
                            ?> <input type="checkbox" name="picture_existance" checked> Picture Existance
                            <?php
                        }
                    }

                    if(isset($result[0]["article_visibility"])){
                        if($result[0]["article_visibility"] == 0){
                            ?> <input type="checkbox" name="article_hide" checked> Hide Article
                            <?php
                        } else if ($result[0]["article_visibility"] == 1){
                            ?> <input type="checkbox" name="article_hide"> Hide Article
                            <?php
                        }
                    }
                    } ?>
                Select a category:
                <select name="categories">
                        <?php
                        $sql = "SELECT id, category FROM category";
                        $db = new DatabaseClass("localhost", "root", "root", "newsapp");
                        $result = $db->select($sql);     
                        if(!empty($result)){
                            foreach($result as $row){
                                if($resultCategoryId[0] == $row["id"]){ ?>
                                    <option name="<?=$row["category"] ?>" value="<?=$row["id"] ?>" selected><?=$row["category"] ?></option>
                                <?php } else { ?>
                                    <option name="<?=$row["category"] ?>" value="<?=$row["id"] ?>"><?=$row["category"] ?></option>
                                <?php }
                             } }?>

                </select>
                
            </div>
        </form>
    </div>
</div>