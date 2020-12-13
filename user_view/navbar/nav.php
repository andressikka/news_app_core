<div class="container">
    <div class="row border">
        <?php if(isset($_SESSION["username"])){ ?>
            <div class="col-md-2 p-2"><a href="adminView.php">Main</a></div>
            <div class="col-md-2 p-2"><a href="adminView.php?cathid=f">First cathegory</a></div>
            <div class="col-md-2 p-2"><a href="adminView.php?cathid=s">Second cathegory</a></div>
            <div class="col-md-6 p-2"><a href="adminView.php?cathid=t">Third cathegory</a></div>
        <?php } else {?>
            <div class="col-md-2 p-2"><a href="index.php">Main</a></div>
            <div class="col-md-2 p-2"><a href="index.php?cathid=f">First cathegory</a></div>
            <div class="col-md-2 p-2"><a href="index.php?cathid=s">Second cathegory</a></div>
            <div class="col-md-6 p-2"><a href="index.php?cathid=t">Third cathegory</a></div>
        <?php } ?>
    </div>
</div>