<div class="container">
    <div class="row border">
        <?php if(isset($_SESSION["username"])){ ?>
            <div class="col-md-2 p-2"><a href="adminView.php">Main</a></div>
            <div class="col-md-2 p-2"><a href="adminView.php?cathid=economy">Economy</a></div>
            <div class="col-md-2 p-2"><a href="adminView.php?cathid=politics">Politics</a></div>
            <div class="col-md-6 p-2"><a href="adminView.php?cathid=history">History</a></div>
        <?php } else {?>
            <div class="col-md-2 p-2"><a href="index.php">Main</a></div>
            <div class="col-md-2 p-2"><a href="index.php?cathid=economy">Economy</a></div>
            <div class="col-md-2 p-2"><a href="index.php?cathid=politics">Politics</a></div>
            <div class="col-md-6 p-2"><a href="index.php?cathid=history">History</a></div>
        <?php } ?>
    </div>
</div>