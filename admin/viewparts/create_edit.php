<div class="container pt-5">
        <div class="row justify-content-center">
            <form action="create.php/?mark=create" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input autocomplete="off" class="form-control" type="text" name="title" placeholder="Article's Title"/><br>
                    <textarea style="resize: none;" class="form-control" rows="10" cols="100" name="body"></textarea><br>

                    <input class="btn btn-primary" name="article_upload" type="submit" value="Post the article">

                    <input class="btn btn-primary" name="picture" type="file">
                    <input type="checkbox" name="article_hide"> Hide Article &nbsp;
                    <?php 
                    if(isset($_GET["mark"]) && $_GET["mark"] == "create"){

                    }
                    if(isset($_GET["mark"]) && $_GET["mark"] == "edit"){
                        ?> <input type="checkbox" name="picture_existance"> Picture Existance
                    <?php } ?>
                    
                    
                </div>
            </form>
        </div>
    </div>